registerServiceWorker();

function registerServiceWorker () {
    if(!('serviceWorker' in navigator)) {
        console.log('Service workers aren\'t supported in this browser.');
        return
    }
    navigator.serviceWorker.register('/serviceworker.js')
        .then(() => initialiseServiceWorker())
}

function initialiseServiceWorker () {
    if(!('showNotification' in ServiceWorkerRegistration.prototype)) {
        console.log('Notifications aren\'t supported.');
        return
    }
    if(Notification.permission === 'denied') {
        console.log('The user has blocked notifications.');
        return
    }
    if(!('PushManager' in window)) {
        console.log('Push messaging isn\'t supported.');
        return
    }
    navigator.serviceWorker.ready
        .then(registration => {
            registration.pushManager.getSubscription()
                .then(subscription => {
                    if(!subscription) {
                        subscribe(registration);
                    }
                })
                .catch(e => {
                    console.log('Error during getSubscription()', e)
                })
        })
}

function subscribe(registration) {
    registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
    })
        .then(subscription => {
            updateSubscription(subscription)
        })
        .catch(e => {
            if (Notification.permission === 'denied') {
                console.log('Permission for Notifications was denied')
            } else {
                console.log('Unable to subscribe to push.', e)
            }
        })
}

function updateSubscription (subscription) {
    const key = subscription.getKey('p256dh');
    const token = subscription.getKey('auth');
    const data = {
        endpoint: subscription.endpoint,
        key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
        token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null
    };

    axios.post('/subscriptions', data)
        .then(() => {
            console.log('subscribed');
        })
}

function urlBase64ToUint8Array (base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/')
    const rawData = window.atob(base64)
    const outputArray = new Uint8Array(rawData.length)
    for(let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i)
    }
    return outputArray
}
