import csv
import re
'''
domain tag 匹配程度
完全匹配时值为 High
包含对方相应单词 并且单词完全匹配时值为 Mid
不匹配时值为 Low

'''



del_str = ['d\'achat','achat','de','reduction','réduction','code','avantage','bonus','privilege','privilège','operation','opération','offre','promo','les','made'
    ,'maison','du','remise']

file = 'FR_Store_Query.csv'
def read_file():
    with open(file) as f:
        reader = csv.reader(f)
        reader = list(reader)
        return reader[1:]


def DomainToWords(reader):
    domain = re.split(r'-|\.',reader)
    return domain[:-1]


def RemoveCouponWords(query):
    query = query.replace('\'','')
    query = query.replace('&','')
    query = query.replace('é','e')
    words = query.split()
    good_words = []
    for word in words:
        if word not in del_str:
            good_words.append(word)
    return good_words

def diff(domain_words,query_words):
    str_domain_words = ''.join(domain_words)
    str_query_words = ''.join(query_words)

    if domain_words == query_words:
        return 'High'


    elif str_domain_words == str_query_words:
        return 'High'



    for i in domain_words:
        if i == str_query_words:
            return "High"
        elif i in str_query_words:
            return 'Mid'

    for a in query_words:
        if a == str_domain_words:
            return 'High'
        elif a in str_domain_words:
            return "Mid"




if __name__ == '__main__':
    output = open("query_store_check.tsv", "w")
    content= read_file()

    for i in content:
        domain = i[0]
        tag = i[3]
        #if domain != "showroomprive.com":
        #    continue

        domain_words = DomainToWords(domain)
        query_words = RemoveCouponWords(tag)
        #checked_result = 'Unclear'

        checked_result = diff(domain_words,query_words)
        if not checked_result:
            checked_result = 'Low'


        #print("%s\n" % ("\t".join(i)))
        output.write("%s\n" % ("\t".join(i)))


