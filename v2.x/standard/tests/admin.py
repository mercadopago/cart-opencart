#coding: utf-8
from splinter import Browser

browser = Browser()
utils = {}
prefix = 'mp_standard_';
payment_methods =['visa', 'master']
ddl_fields = {'status': 'Enabled', 'category_id': 'Computers & Tablets', 'debug': 'Enabled', 
              'sandbox': 'Enabled', 'type_checkout': 'Lightbox', 'order_status_id': 'Pending', 
              'order_status_id_completed': 'Complete', 'order_status_id_pending': 'Pending', 
              'order_status_id_canceled': 'Canceled', 'order_status_id_in_process': 'Processing', 
              'order_status_id_rejected': 'Denied', 'order_status_id_refunded': 'Refunded', 
              'order_status_id_in_mediation': 'Processing', 'country': 'Brasil', 'installments': 'maximum'}
public_key = 'your_public_key'
access_token = 'your_access_token'
client_id = 'your_client_id'
client_secret = 'your_client_secret'
text_fields = {'public_key': public_key,
               'access_token': access_token,
               'client_id': client_id , 'client_secret': client_secret,
               'url': 'http://localhost:8888/opencart2/'} 



def login():
    fields = {"username": "admin", "password": "admin"}
    url = 'http://localhost:8888/opencart2/admin/index.php?route=common/login'
    url_admin = 'admin/index.php?route=common/dashboard&token='
    browser.visit(url)

    for k, v in fields.items():
        browser.fill(k, v)
    btn_login = browser.find_by_tag('button')[0]
    btn_login.click()
    assert url_admin in browser.url
    utils['token'] = browser.url.split('token=')[1]

def fill_admin_data():
    url = 'http://localhost:8888/opencart2/admin/index.php?route=payment/mp_standard&token=%s' % utils['token']
    url_redirect = 'admin/index.php?route=extension/payment&token=%s' % utils['token']
    browser.visit(url)

    if browser.find_by_name('mp_standard_public_key').first.visible:
        del text_fields['client_id']
        del text_fields['client_secret']
    else:
        del text_fields['public_key']
        del text_fields['access_token']

    for k, v in text_fields.items():
        field_name = '%s%s' % (prefix, k)
        browser.fill(field_name, v)

    for k, v in ddl_fields.items():
        field_name = '%s%s' % (prefix, k)
        browser.select_by_text(field_name, v)

    for element in payment_methods:
        browser.find_by_value(element)[0].check()

    browser.find_by_id('btn_save').click()
    assert url_redirect in browser.url


def check_if_admin_data_was_saved():
    admin_url = 'http://localhost:8888/opencart2/admin/index.php?route=payment/mp_standard&token=%s' % utils['token']
    browser.visit(admin_url)

    if browser.find_by_name('mp_standard_public_key').first.visible:
        text_fields['public_key'] = public_key
        text_fields['access_token'] = access_token
    else:
        text_fields['client_id'] = client_id
        text_fields['client_secret'] = client_secret

    for k, v in text_fields.items():
        field_name = '%s%s' % (prefix, k)
        elem = browser.find_by_name(field_name)
        assert elem.value == v

    for k, v in ddl_fields.items():
        field_name = '%s%s' % (prefix, k)
        select = browser.find_by_name(field_name).first
        option = filter(lambda x: x.selected == True, select.find_by_tag('option'))[0]
        assert v == option.text

if __name__ == '__main__':
    login()
    fill_admin_data()
    check_if_admin_data_was_saved()
    browser.quit()
