#coding: utf-8
import time

try:
    from splinter import Browser
except Exception, e:
    install_command = 'sudo pip install selenium splinter'
    print("Error on import - %s" % e)
    print('Tip: You probably forgot to run "%s".' % install_command)
    exit()


class BaseConfig(object):

    """docstring for BaseConfig"""

    def __init__(self):
        self._browser = Browser("chrome")
        self.countries = ("MLA", "MLB", "MLC", "MCO", "MLM", "MLV", "MPE")
        self.currencies = ('ARS', 'BRL', 'MEX', 'CHI', 'PEN', 'VEF', 'COP')


    def visit_url(self, url_to_visit):
        self._browser.visit(url_to_visit)
        return self

    def get_element_in_page(self, element_name):
        return self._browser.find_by_id(element_name).first

    def then(self):
        return self

    def wait(self, seconds):
        time.sleep(seconds)
        return self

if __name__ == '__main__':
    try:
        url = "http://www.mercadopago.com.br"
        x = BaseConfig()
        x.visit_url(url).then()\
            .get_element_in_page("common-register") \
            .click()
        x.get_element_in_page("signupFirstName").value = "Henrique"
        x.get_element_in_page("signupLastName").value = u'Juguetón'

    except Exception, e:
        print("Error - %s" % e)
