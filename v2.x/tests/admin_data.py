import json
from splinter import Browser
from base_config import BaseConfig


class AdminData(BaseConfig):

    """docstring for ClassName"""

    def __init__(self):
        super(AdminData, self).__init__()
        admin_data_file = open('admin_data.json', 'r').read()
        config_file = open('config_admin.json', 'r').read()
        self.admin_data = json.loads(admin_data_file)
        self.config = json.loads(config_file)

    def fill_status(self, module_status):
        self._browser.select(self.config['status'], module_status)

    def fill_country(self, country):
        self._browser.select(self.config['country'], country)
        return self

    def fill_public_key(self, pk):
        self._browser.fill(self.config['public_key'], pk)
        return self

    def fill_access_token(self, access_token):
        self._browser.fill(self.config['access_token'], access_token)
        return self

    def fill_category(self, store_category):
        self._browser
        return self

    def fill_debug_mode(self, debug_mode_option):
        self._browser
        return self

    def select_payment_methods(self, payment_methods=[]):
        for pm in payment_methods:
            self._browser.check(self.config['payment_method'], pm)

        return self

    def select_order_status(self, order):
        self._browser
        return self
