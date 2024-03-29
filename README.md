# Overdose Preview Email

M2 extension provides opportunity to view emails in admin area.

## Installation
- Run: `composer config repositories.overdosedigital-email-preview vcs git@github.com:Overdose-Digital/magento2-email-preview.git`.
- Add `overdose/module-preview-email` to "require section" in `composer.json` file OR run: `composer require overdose/module-preview-email --no-update`
- `composer update overdose/module-preview-email`

## Functionality
- preview order emails
- preview invoice emails
- preview customer emails
- preview shipment emails
- preview creditmemo emails
- preview contact us form emails
- preview reset password emails
- preview subscription subscription success emails

#### Usage
Move to Admin Menu->Marketing->Communications->Preview Email.
![Grid](README/wiki_email-preview_grid.png)


Select type of email to preview > view > select number ID(for Order/Invoice) or Customer Name(for Customers emails).
![Options](README/wiki_email-preview_email-options.png)


Select store > click 'preview' button.
![View](README/wiki_email-preview_preview.png)

## Support
Magento 2.0 | Magento 2.1 | Magento 2.2 | Magento 2.3 | Magento 2.4
:---: | :---: | :---: | :---: | :---:
? | 1.0.0 | 1.0.0 | ok | ok
