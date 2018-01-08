file1 = 'date1'
file2 = 'date2'
with open(file1) as tmp:
    date1_li = []
    for date1 in tmp.readlines():
        date1 = date1.strip().split(",")
        dic = {date1[0]:date1[1:]}
        date1_li.append(dic)
    '''
    print(date1_li)
    print('----------\n')
    '''

with open(file2) as tmp:
    tag = 0
    for date2_line in tmp.readlines():
        date2_list = []
        date2_line = date2_line.strip().split(",")

        for i in date2_line[1:]:
            i = i.split(':')
            i[1] = int(i[1])
            date2_list.append(i)
        date2_dic = dict(date2_list)

        if date2_dic:
            top_list = list(date2_dic.values())
            top_list.sort()
        else:
            head_domain , end_tag = ''.join(list(date1_li[tag].keys())), '\t'.join(date1_li[tag][date2_line[0]])
            print(head_domain+"\t"+end_tag)
            tag += 1
            continue

        add_list = date1_li[tag][date2_line[0]]
        while True:
            if len(add_list) >= 3:
                break
            else:
                add_index = list(date2_dic.values()).index(top_list.pop())
                add_key = list(date2_dic.keys())[add_index]
                add_list.append(add_key)
                add_list = list(set(add_list))
        head_domain ,end_tag = list(date1_li[tag].keys())[0],'\t'.join(add_list)
        print(head_domain+'\t'+end_tag)
        tag += 1
