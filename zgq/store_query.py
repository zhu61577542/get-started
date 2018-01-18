import csv
import re

del_str = ['bon','d\'achat','achat','de','reduction','reduc','réduction','code','avantage','bonus','privilege','privilège','operation','opération','offre','promo','la','le','les','made'
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
    words = query.split()
    good_words = []
    for word in words:
        if word not in del_str:
            good_words.append(word)
    return good_words



output = open("query_store_check.tsv", "w")

content= read_file()

for i in content:
    domain = i[0]
    tag = i[3]
    domain_words = DomainToWords(domain)
    query_words = RemoveCouponWords(tag)
    checked_result = 'Unclear'
    if domain_words == query_words:
        checked_result = 'High'
    elif ''.join(domain_words) in query_words:
        checked_result = 'Mid'
    else:
        checked_result = 'Low'
    i[4] = checked_result
    output.write("%s\n" % ("\t".join(i)))

