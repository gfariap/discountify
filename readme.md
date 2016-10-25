# Discountify
### The new look of discounts

Built with PHP and [Laravel] (https://laravel.com/)

Developed by Gabriel Faria and designed by [Jéssica Serafim] (https://www.behance.net/jessicaserafim)

Thinking about the daily problems that we face with e-commerces, one thing that frustrates us both is the inability to view and apply our discount codes before getting to the cart or simulating a purchase to get to checkout.

The problem is even bigger when you consider today's technology and it's not possible to do a simple thing like that. To solve this problem, we came up with Discountify.

![discountify](https://github.com/gfariap/discountify/blob/master/public/img/logo.png)

Discountify is an embedded app made for Shopify. You can add it to your store and it works like this:
Once the customers are looking through the store, they see a floating button and once they click, it opens a bar on the top of the page.

All you need to do is insert the discount code there and it applies to the whole website. You can visualize the discounts - on the applicable products - instantaneously on every page. You don’t need to keep checking your cart or wait until checkout. 

The discount bar can be customized according to the website layout.

---

## Using the app

As an embedded app, Discountify was installed on our [dev store](https://discountify-dev.myshopify.com) and it has all the Installation/OAuth authentication routes and methods, being ready for the app store. The only permissions that we ask are to change themes and assets using the Shopify API.

Once installed, the Discountify home will look like this:

![discountify_home](https://drive.google.com/uc?export=download&id=0B6ErOPj5SIMZTzlfTnA5dmdLZ28 "Discountify")

Here we have two steps, `Register discount codes` and `Customize app theme`, as described:

### Register discount codes

One of the problems we faced was the Discounts API being accessible only for Shopify Plus members, so we had to do a workaround to get the discount codes. This section was created to supply the codes for this demo, but the final app would be made by a Plus account, being able to access all the discount codes registered in your store.

For now, the client can register all the discount codes from his store to be accessible by our app. For demo purposes, only the value and percentage discount codes can be registered and they are applicable to everything in the store, but that's a limitation that would be gone with the Plus membership.

As displayed here:

![discountify_codes](https://drive.google.com/uc?export=download&id=0B6ErOPj5SIMZNzRtY2RfVElhdWs "Register discount codes")

Discountify shows a list of discount codes registered, that you can delete from or register new ones. After registering everything, the user has to click on "Update snippet on the store" and this action will generate two snippets on your theme:

* `snippets\discountify_bar.liquid`
* `snippets\discountify_preview.liquid`

Their usage will be described afterwards.

### Customize app theme

To be theme-friendly, we made a functionality for customizing the look of our snippets on your store, so you can adapt them to your style. The customize screen looks like:

![discountify_customize](https://drive.google.com/uc?export=dowload&id=0B6ErOPj5SIMZbFJ6NmdZV0VxTTA "Customize theme")

The preview updates as the fields are changed and upon hitting `Save`, the app will save your theme preferences and generate the Discountify style on your theme assets. The asset generated is called `assets\discountify.css.liquid`

### Including the created assets on your store

After creating both the snippets and the asset, we need to include them in your theme files. First, open your layout file in your main theme. At the end of the `head` section, include the following line:

`{{ 'discountify.css' | asset_url | stylesheet_tag }}`

So that Discountify styles can be applied to every page. Still at the layout file, include the following line to the end of the `body` section:

`{% include 'discountify_bar' %}`

Save and exit the layout file. Now every page on your store has the needed styles and displays the tag icon on the top left corner, showing the Discountify bar when clicked.

![discountify_bar](https://drive.google.com/uc?export=download&id=0B6ErOPj5SIMZNDlqd0NZbk5IT1U "Discountify bar")

### Displaying the preview discounted price

Now that everything works, in every place on your store that has a product and its value, you can add a simple snippet to show the discounted price if a valid discount code was inserted on the Discountify bar. To do so, just add:

`{% include 'discountify_preview' %}`

Where you want it to appear. That's it, now your customers can preview the discounted prices of individual items without needing to simulate an order or go to checkout.

![discountify_checkout](https://drive.google.com/uc?export=download&id=0B6ErOPj5SIMZTHM2U05VY1diczA "Discountify preview")

---

## Problems faced

The first problem was that none of us had any experience developing apps for Shopify, so we took our time to read the documentation, learn what we could and couldn't do and what was the best type of app/integration for what we needed. We ended up doing an embedded app that interacts with the Shopify API.

The second problem was learning that we can't interact with the Discounts API without being a Shopify Plus partner, so we had to do a workaround to get the discounts. We made a functionality to register the discount codes that you want available for your app. In the snippet that we create on your theme, there is a list of valid codes that we use to validate and include the value on the preview. For it to be accessible through every page, the app creates a cookie and reads from it to get the applied discount code.

The third problem was the limited time. We did our best to create a finished product, but there was a few bugs that we couldn't solve in time, like deleting a cookie from javascript, that works differently in every browser, so there's times that removing your code doesn't actually remove the discounted preview. There is a couple of small ones too, like the fixed color of the apply button on the bar and the visibility of the discounted price div.

Even so, we came very close to develop a fully functional embedded app and we're very proud of the result achieved in less than two days.

---

## Shopify store with Discountify up and running

https://discountify-dev.myshopify.com

Password for the store: `braust`

To test the app directly, I can either:
* Provide a staff account on the dev store (send me an e-mail: gabriel.fariap@gmail.com);
* Describe the installation process, as follows.

## Installing and configuring this repository

1. `git clone` this repository
2. Install [composer](https://getcomposer.org/) to manage PHP dependencies
3. `composer install` on the project folder
4. Copy `.env.example` to `.env`
5. Configure your database and Shopify keys on `.env`
6. `php artisan key:generate` on the project folder

This must get you there. If you want to change front-end code:

1. Install [node](https://nodejs.org/en/), [npm](https://www.npmjs.com/) and [gulp](http://gulpjs.com/)
2. `npm install` on the project folder

Got a problem or noticed a missing step? E-mail me at gabriel.fariap@gmail.com
