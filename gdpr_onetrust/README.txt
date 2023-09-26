General Data Protection Regulation using One Trust 8.x - 1.x
==============================================================

This module intends to deal with the EU Directive on Data Protection Regulation
that comes into effect on 25th May 2018.
From that date, if you are not compliant or visibly working towards compliance,
you run the risk of enforcement action, which can include a fine for a serious 
breach.

How it works.
=============

The module displays a overlay at the top of website to make
users aware of the fact that cookies are being set. The user may then give
his/her consent or move to a page that provides more details. Consent is given
by user pressing the agree buttons or by continuing browsing the website.

The module provides a settings page to place the UUID which need to be procured
from OneTrust https://onetrust.com/.

Installation.
=============

1. Unzip the files to the "sites/all/modules" or "modules" directory 
and enable the module.

2. Go to the admin/config/system/gdpr-onetrust page to place the UUID procured
from OneTrust.

3. You may want to create a cookie policy page that would explain how your site 
uses cookies.

4. To display the cookie table on the cookie policy page place this div 
<div id="optanon-cookie-policy"></div> in the desired location in cookie policy 
page.

Or

Alternatively you can use the "One Trust Cookie table" block and place it 
according to your site build.

5. To place the cookie settings button on the website you can place the 
menu item "Cookie Settings" from admin/structure/menu/manage/account to
footer menu of the website.

or

place the link <a class="optanon-show-settings">Cookie Settings</a> in desired 
location on the website.

or

Alternatively you can use the "One Trust cookie settings" block and place it 
according to your site build.

NOTICE: The module does not audit your cookies nor does it prevent cookies
from being set.
