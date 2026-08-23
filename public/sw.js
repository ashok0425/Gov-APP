/* Service worker for the mobile web app.
 *
 * It does one thing: when a page navigation fails because there is no
 * network, it answers with /mobile/offline.html instead of letting the
 * browser paint its own "site can't be reached" error with the URL on it.
 * Every other request — and every navigation that succeeds — goes straight
 * to the network; nothing else is cached, so pages never go stale.
 *
 * It lives at the site root so its scope covers every mobile URL. */

var CACHE = 'offline-v1';
var OFFLINE_URL = '/mobile/offline.html';

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE)
            .then(function (cache) { return cache.add(new Request(OFFLINE_URL, { cache: 'reload' })); })
            .then(function () { return self.skipWaiting(); })
    );
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (keys) {
            return Promise.all(keys.filter(function (key) { return key !== CACHE; }).map(function (key) {
                return caches.delete(key);
            }));
        }).then(function () { return self.clients.claim(); })
    );
});

self.addEventListener('fetch', function (event) {
    if (event.request.mode !== 'navigate') return;

    event.respondWith(
        fetch(event.request).catch(function () {
            return caches.match(OFFLINE_URL).then(function (cached) {
                return cached || new Response('No internet connection', {
                    status: 503,
                    headers: { 'Content-Type': 'text/plain; charset=utf-8' },
                });
            });
        })
    );
});
