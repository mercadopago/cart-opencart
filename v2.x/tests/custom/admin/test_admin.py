import unittest
import os.path
import json
import splinter

class AdminTest(unittest.TestCase):

    def setUp(self):
        json_file = open(
            os.path.dirname(__file__) + '../../admin_data.json', 'r').read()
        self.config = json.loads(json_file)

    def tearDown(self):
        pass

    def test_must_load_payment_methods(self):
        pass

    def test_must_save_admin_data(self):
        pass

    def test_must_reload_payment_methods_according_to_country(self):
        pass

if __name__ == '__main__':
    unittest.main()
