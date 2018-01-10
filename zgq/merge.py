'''
合并两个文件，使data1中具有3个tag，不足的tag_line数据从data2中补齐
原则优先取click高的tag，并且不能与data1中的重复
https://docs.google.com/spreadsheets/d/1l8EPVl9Vft44odv2eYS0ie5Bsin90tLBflLtAehYQDY/edit#gid=0
'''

add_to_file = 'data1.csv'
data_file = 'data2.csv'

# 把data1文件读入一个列表 格式为 [{domain:[tag,tag,....]}]
def read_base():
    with open(add_to_file) as src:
        domain_file = src.readlines()
        store_tags_list = []
        for line in domain_file[1:]:
            line = line.strip().split(",")
            domain = line[0]
            tags = line[1:]
            while '' in tags:
                tags.remove('')
            dic = {domain: tags}
            store_tags_list.append(dic)
    return store_tags_list


# 获取data2文件内容,提取tag数据形成完整的内容
def read_data(store_tag):
    save_file = open('save.csv','a')
    with open(data_file) as src:
        tag_line = 0
        tag_file = src.readlines()
        for data_file_line in tag_file[1:]:
            tag_list = []
            data_file_line = data_file_line.strip().split(",")
            while '' in data_file_line:
                data_file_line.remove('')

            for i in data_file_line[1:]:
                i = i.split(':')
                i[1] = int(i[1])
                tag_list.append(i)
            all_data_dic = dict(tag_list)
            if all_data_dic:
                top_tag_number = list(all_data_dic.values())
                top_tag_number.sort()
            else:
                domain = ''.join(list(store_tag[tag_line].keys()))
                tag = (''.join(store_tag[tag_line][domain]))
                save_file.write(domain+'\t'+tag+'\n')
                tag_line += 1
                continue
            add_list = store_tag[tag_line][data_file_line[0]]  

            while True:
                if len(add_list) >= 3:
                    break
                else:
                    add_index = list(all_data_dic.values()).index(top_tag_number.pop())
                    add_key = list(all_data_dic.keys())[add_index]
                    add_list.append(add_key)
                    add_list = list(set(add_list))

            domain, tag = list(store_tag[tag_line].keys())[0], '\t'.join(add_list)
            save_data = domain + '\t' + tag + '\n'
            save_file.write(save_data)
            tag_line += 1



data = read_base()
read_data(data)





