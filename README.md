##Product Questions Module

This module add functionality to allow customer to ask questions for different products and also read questions that are asked by other customers previously, so avoiding any doubts in customer mind.

##Supports: 
version - 2.3.x

##Vendor name : Invigorate
##Module name : ProductQuestions

##How to install Extension

1. Download the zip file.
2. Unzip the file
3. Create a folder [Magento_Root]/app/code/Invigorate/ProductQuestions
4. move the unzipped files to folder you created on step 3.

##How to To Enable Extension:
- php bin/magento setup:upgrade
- php bin/magento cache:clean
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush

#or you can also run:
- php bin/magento module:enable Invigorate_ProductQuestions

##How to Disable Extension:
- php bin/magento module:disable Invigorate_ProductQuestions
- php bin/magento setup:upgrade
- php bin/magento cache:clean
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush