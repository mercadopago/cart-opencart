#coding: utf-8
from splinter import Browser
import time
browser = Browser('chrome')
base_url = 'http://localhost:8888/oc21/'

def buy_product():
    url_home = '%sindex.php?route=common/home' %base_url
    find_button = lambda x: x['onclick'] == "cart.add('40');"
    browser.visit(url_home)
    button_add_to_cart = filter(find_button, browser.find_by_tag('button'))[0]
    button_add_to_cart.click()
    

def fill_guest_checkout_data():
    url_checkout = '%sindex.php?route=checkout/checkout' % base_url
    browser.visit(url_checkout)
    fill_customer_checkout_type()
    fill_guest_customer_data()
    #]fill_authenticated_customer_data()



def fill_authenticated_customer_data():
    time.sleep(1)
    email_field = browser.find_by_id('input-email').first
    email_field.value = 'brunobemfica@gmail.com'
    password_field = browser.find_by_id('input-password').first
    password_field.value = 'admin'
    browser.find_by_id('button-login').click()
    time.sleep(2)
    browser.find_by_id('button-payment-address').click()
    time.sleep(1)
    browser.find_by_id('button-shipping-address').click()
    time.sleep(1)
    browser.find_by_id('button-shipping-method').click()
    time.sleep(1)
    browser.find_by_name('agree').click()
    time.sleep(1)
    browser.find_by_id('button-payment-method').click()
    time.sleep(5)
    browser.find_by_name('MP-Checkout').first.click()
    time.sleep(5)
    div = browser.find_by_id('MP-Checkout-dialog')
    iframe = div.find_by_id('MP-Checkout-IFrame')
    time.sleep(3)
    btn = iframe.find_by_id('next').first
    print btn.text
    btn.click()


def select_payment_type(payment_type='other_card'):
    pass

def fill_custom_payment_data():
    pass

def fill_customer_card_payment_data():
    pass


def fill_customer_checkout_type(customer_type = 'guest'):
    div_user = browser.find_by_css('.panel-heading')[0]
    div_user.click()
    browser.is_element_present_by_name('account', wait_time=10)
    guest_selector = browser.find_by_name('account')[1] if customer_type == 'guest' else browser.find_by_name('account')[0]
    guest_selector.click()
    button_account = browser.find_by_id('button-account').first
    button_account.click()


def fill_guest_customer_data():
    prefix = 'input-payment-'
    user_data = {'firstname': 'John', 'lastname': 'Doe', 'email': 'test_user_53699615@testuser.com', 
                 'telephone': '55123456789', 'address-1': '805 King Farm Boulevard',
                 'city': 'Rockville', 'postcode': '20850'}
    for k, v in user_data.items():
        field_id = '%s%s' % (prefix, k)
        browser.is_element_present_by_id(field_id, 2)
        browser.find_by_id(field_id).first.fill(v)

    # time.sleep(1) to wait until the element is visible
    browser.select_by_text('country_id', 'United States')
    browser.select_by_text('zone_id', 'Maryland')
    time.sleep(1)
    browser.find_by_id('button-guest').first.click()
    time.sleep(1)
    browser.find_by_id('button-shipping-method').first.click()
    time.sleep(1)
    browser.find_by_name('agree').first.click()
    time.sleep(1)
    browser.find_by_id('button-payment-method').first.click()

if __name__ == '__main__':
    buy_product()
    fill_guest_checkout_data()
    
