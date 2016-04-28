#coding: utf-8
#For Mac only.
from getpass import getuser
from subprocess import call

user = getuser()
user_dir = '/Users/%s/chromewebdriver' % user
cd_path = '$CHROMEDRIVER_PATH=%s' % user_dir 
path = 'PATH=$PATH:$CHROMEDRIVER_PATH'
call(['curl','-O', 'http://chromedriver.storage.googleapis.com/2.20/chromedriver_mac32.zip'])
call(['unzip', 'chromedriver_mac32.zip'])
call(['mkdir', user_dir])
call(['mv', 'chromedriver', user_dir])
call(['rm', '-rf', 'chromedriver_mac32.zip'])
call(['echo', cd_path, '~/.bash_profile'])
call(['echo', path, '~/.bash_profile'])