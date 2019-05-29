(() => {
    'use strict';

    const WebPush = {
        init () {
            self.addEventListener('push', this.notificationPush.bind(this));
            self.addEventListener('notificationclick', this.notificationClick.bind(this));
        },

        /**
         * Handle notification push event.
         *
         * https://developer.mozilla.org/en-US/docs/Web/Events/push
         *
         * @param {NotificationEvent} event
         */
        notificationPush (event) {
            if (!(self.Notification && self.Notification.permission === 'granted')) {
                return
            }

            // https://developer.mozilla.org/en-US/docs/Web/API/PushMessageData
            if (event.data) {
                event.waitUntil(
                    this.sendNotification(event.data.json())
                )
            }
        },

        /**
         * Handle notification click event.
         *
         * https://developer.mozilla.org/en-US/docs/Web/Events/notificationclick
         *
         * @param {NotificationEvent} event
         */
        notificationClick (event) {
            console.log(event.notification);
            self.clients.openWindow(event.notification.actions[0].action)
        },

        /**
         * Send notification to the user.
         *
         * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
         *
         * @param {PushMessageData|Object} data
         */
        sendNotification (data) {
            return self.registration.showNotification(data.title, data)
        },
    };

    WebPush.init()
})();