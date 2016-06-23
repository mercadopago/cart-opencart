import json
from splinter import Browser



class BaseConfig(object):
	"""docstring for BaseConfig"""
	def __init__(self):
		self._browser = Browser()

	def and(self):
		return self

	def visit_url(self, url_to_visit):
		self._browser.visit(url_to_visit)
	
	def then(self):
		return self.and()
		