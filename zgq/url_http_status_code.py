from urllib import request
import re
head = {'User-Agent':'Googlebot'}
#从www.dukerealestateclub.com提取子页面链接
def open_index():
    page_url_list = []
    url = 'http://www.dukerealestateclub.org/index_gg.html'
    html = request.Request(url,headers=head)
    req = request.urlopen(html)
    webpate = req.read().decode('utf-8')
    ma = re.findall(r'<a href[^>].+">',webpate)
    for i in ma:
        i = i[9:-2]
        page_url_list.append(i)
    return page_url_list

#从www.dukerealestateclub.com子页面提取链接指向反链网站的链接
def open_page(page_url_list):
    back_link_list = []
    for i in page_url_list:
        url = i
        html = request.Request(url, headers=head)
        req = request.urlopen(html)
        webpate = req.read().decode('utf-8')
        ma = re.findall(r'<a href[^>].+">', webpate)
        for a in ma:
            a = a[9:-2]
            back_link_list.append([i,a])
    return back_link_list

#查看反链网站页面中是否存在链接，如果存在调用测试返回码函数
def open_back_link(back_link_list):
    exist_link_list = []
    for i in back_link_list:
        (index_for_url,page_url) = i
        html = request.Request(page_url, headers=head)
        req = request.urlopen(html)
        http_code = req.getcode()
        webpage = req.read().decode('utf-8')
        ma = re.findall(r'<a href[^>]+>',webpage)
        if not ma or http_code != 200:
            print('not link:%s --> %s' %(index_for_url,page_url))
        else:
            exist_link_list.append([index_for_url, page_url])
    test_access(exist_link_list)

#获取反链网站的返回码
def test_access(test_link):
    for i in test_link:
        (index_for_url, page_url) = i
        html = request.Request(page_url, headers=head)
        req = request.urlopen(html)
        http_code = req.getcode()
        webpage = req.read().decode('utf-8')
        ma = re.findall(r'<a href[^>]+>', webpage)
        if len(ma) > 2:
            print('%s to Entry page %s http code: %s'%(index_for_url, page_url,http_code))
        else:
            ma = ''.join(ma)
            ma = ma[9:-2]
            html = request.Request(ma, headers=head)
            req = request.urlopen(html)
            http_code = req.getcode()

            print('%s --> %s --> %s http code: %s'%(index_for_url, page_url, ma, http_code))

data = open_index()
page = open_page(data)
open_back_link(page)