import json
from splinter import Browser
from base_config import BaseConfig

class BuyerData(BaseConfig):

    """docstring for BuyerData"""

    def __init__(self):
        super(BuyerData, self).__init__()
        buyer_data_file = open('buyer_data.json', 'r').read()
        config_file = open('config_buyer.json', 'r').read()
        self.buyer_data = json.loads(buyer_data_file)
        self.config = json.loads(config_file)

    def fill_customer_name(self):
        self._browser.find_by_id('')

    def fill_customer_email(self):
        pass

    def fill_shipment_street_name(self):
        pass

    def fill_shipment_street_number(self):
        pass

    def fill_shipment_obs(self):
        pass

    def fill_shipment_postcode(self):
        pass

    def fill_shipment_country(self):
        pass

    def fill_shipment_state(self):
        pass