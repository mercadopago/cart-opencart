import json
from splinter import Browser
from base_config import BaseConfig

class BuyerData(BaseConfig):

    """Class to fill Buyer data whenever starting a checkout process"""

    def __init__(self):
        super(BuyerData, self).__init__()
        config_file = open('config_buyer.json', 'r').read()
        self.config = json.loads(config_file)

    def fill_customer_name(self, ):
        self._browser.fill()
        return self

    def fill_customer_email(self, customer_email):
        self._browser.fill(self.config['email'], customer_email)
        return self

    def fill_shipment_street_name(self, street_name):
        self._browser.fill(config['street_name'], street_name)
        return self

    def fill_shipment_street_number(self, street_number):
        self._browser.fill(config['street_number'], street_number)
        return self

    def fill_shipment_obs(self, observation):
        self._browser.fill(config['observation'], observation)
        return self

    def fill_shipment_postcode(self, postcode):
        self._browser.fill(config['postcode'], postcode)
        return self

    def fill_shipment_country(self, shipment_country):
        self._browser.select(config['shipment_country'], shipment_country)
        return self

    def fill_shipment_state(self, shipment_state):
        self._browser.select(config['shipment_state'], shipment_state)
        return self