(function () {

    // to be replaced with the origin of the hosted backend. example: https://auth.aaas.com
    const BACKEND_ORIGIN = window.location.origin

    const openPopup = function(url, width, height) {
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 4;
        const authWindow = window.open(
            url,
            'Auth Page',
            `width=${width}` +
            `, height=${height}` +
            `, top=${top}` +
            `, left=${left}` +
            'toolbar=no, menubar=no, location=no, status=no, directories=no, scrollbars=no, resizable=no'
        )
        if (window.focus) {
            authWindow.focus()
        }
        return authWindow
    }

    const init = function (isbn, redirectUrl) {

        const config = {
            authOrigin: BACKEND_ORIGIN,
            authPath: '/api',
            isbn: isbn,
            redirectUrl: redirectUrl
        }

        const interval = 1000
        const popupWidth = 640
        const popupHeight = 640

        function authorize () {
            let url =
                config.authOrigin +
                config.authPath +
                '?isbn=' +
                config.isbn

            let authWindow = openPopup(url, popupWidth, popupHeight)

            window.addEventListener('message', messageHandler, false)

            function messageHandler(event) {
                if (event.origin != config.authOrigin) {
                    return
                }
                clearInterval(timer)
                window.removeEventListener('message', messageHandler, false)
                authWindow.close()
                if (event.data.status === 'success') {
                    //window.location = config.redirectUrl + '?data=' + event.data.jwt
                    window.location = config.redirectUrl
                } else {
                    return
                }
            }

            let timer = setInterval(function() {
                if (authWindow.closed) {
                    clearInterval(timer)
                    window.removeEventListener('message', messageHandler, false)
                    return
                }
            }, interval)
        }

        function attachClickHandler(element) {

            element.addEventListener('click', clickHandler, false)
            function clickHandler(e) {
                e.preventDefault()
                authorize()
            }
        }

        return {
            attachClickHandler: attachClickHandler
        }
    }

    const setupLinks = function (redirectUrl) {
        links = document.querySelectorAll('[data-aaas]')
        links.forEach(function (element) {
            let ISBN = element.dataset.isbn
            init(ISBN, redirectUrl).attachClickHandler(element)
        })
    }

    window.AuthSDK = { setupLinks }
})()