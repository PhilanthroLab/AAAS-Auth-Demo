AAAS JavaScript Authentication SDK
============================

## Installation

run ```composer install```.

Make the following folders writeable
	```bootstrap```
	```storage```

setup an nginx or apache server to the ```public``` folder


## Usage
The JS SDK can be found in the ```public/sdk``` folder.

Data attributes should be added to the elements that when clicked, will trigger the authentication process.

The SDK should be initialized with a redirect url.

When the user clicks on the element, a popup window opens and the user begins the authentication process.

After a successful authentication, the pop up closes and the user is redirected to the redirect url that was supplied during the initialization of the SDK. 

A JWT containing the user's email, ISBN number and the selected author will be passed as a query parameter to the supplied redirect url as in the example below.

```https://rightsplatform.com/articles?data=eyJhbGc...VCJ9.eyJzdW...IyfQ.SflK...sw5c```

### Example 
```html
<!--include data attributes on the links to be clicked by the user-->
<li data-aaas data-isbn="978-3-16-148410-0">
    <a href="">Request Permission</a>
</li>

<!-- include sdk in the client's page-->
<script type="text/javascript" src="path/to/authsdk.js"></script>
<script type="text/javascript">

    // url to be redirected to after a successful authentication
    let redirectUrl = 'https://rightsplatform.com/articles'
    
    // initialize the sdk
    AuthSDK.setupLinks(redirectUrl)
</script>
```
