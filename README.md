# Overdose Preview Email

M2 extension provides opportunity to view emails from BO.

## Installation

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

### or you can install by composer
- If NOT packegist, run: `composer config repositories.overdosedigital-email-preview vcs git@bitbucket.org:overdosedigital/email-preview.git`.
- Add `overdose/email-preview` to "require section" in `composer.json` file OR run: `composer require overdose/email-preview --no-update`
- `composer update overdose/email-preview`

## Functionality
- preview order emails
- preview invoice emails
- preview customer emails

## Configurations:
there is no configuration

## Additional
#### Dependencies
You can find the list of modules that have dependencies on Overdose_PreviewEmail module, in the `require` section of the `composer.json` file located in the same directory as this `README.md` file.
#### Usage
Move to Admin Menu->Marketing->Communications->Preview Email
Select type of email to preview > view > select number ID(for Order/Invoice) or Customer Name(for Customers emails), select store > click 'preview' button 

## Support
Magento 2.0 | Magento 2.1 | Magento 2.2 | Magento 2.3 | Magento 2.4
:---: | :---: | :---: | :---: | :---:
x | x | x | x | ok
