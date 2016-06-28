import unittest
import os.path
import json
from tests.admin_data import AdminData


class AdminTest(unittest.TestCase):

    def setUp(self):
        json_file = open(
            os.path.dirname(__file__) + '../../buyer_data.json', 'r').read()
        self.config = json.loads(json_file)
        self.browser = AdminData()

    def tearDown(self):
        pass

    def test_must_pay_product_with_credit_card(self):
        pass
    def test_must_redirect_if_payment_is_concluded(self):
        pass

    def test_must_load_card_data_when_credit_card_change(self):
        pass

    def test_must_load_installments_when_credit_card_change(self):
        pass


if __name__ == '__main__':
    print "before file"
    print __file__
    print "after file"
    unittest.main()
