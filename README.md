<h2>Overdose Preview Email</h2>

### Overview

Module Overdose\PreviewEmail give an opportunity to view emails from BO.

### Installation

You can install Overdose Preview Email by cloning this repo:
git clone git@bitbucket.org:overdosedigital/email-preview.git

### Installation steps

```bash
move to the project folder app/code/Overdose folder
run git clone git@bitbucket.org:overdosedigital/email-preview.git PreviewEmail
```

Enable the module:

    ```bash
    php bin/magento module:enable Overdose_PreviewEmail
    php bin/magento setup:upgrade
    php bin/magento c:c
    ```
## Requirements

Works with Magento 2.0-2.3

### Dependencies

You can find the list of modules that have dependencies on Overdose_PreviewEmail module, in the `require` section of the `composer.json` file located in the same directory as this `README.md` file.
### Usage

Move to Admin Menu->Marketing->Communications->Preview Email
Select type of email to preview > view > select number ID(for Order/Invoice) or Customer Name(for Customers emails), select store > click 'preview' button 
