// Difine cache name
const cacheNames = ["V2"];

// Call Install Event
self.addEventListener("install", (e) => {
  // console.log("[Service Worker] Installing Service worker...");
});

// Call Activate Event
self.addEventListener("activate", (e) => {
  // console.log("[Service Worker] Activated...");
  // Remove Unwanted Caches
  e.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== cacheNames) {
            console.log("Service Worker Clear Old Cache");
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Call Fetch Event
self.addEventListener("fetch", (e) => {
  // console.log("Service Worker: Fetching...");
  e.respondWith(
    fetch(e.request)
      .then((res) => {
        // Check if the response is a partial response (status code 206)
        if (!res.ok || res.status === 206) {
          return res; // Do not cache partial responses
        }

        // Make Copy/Clone Of Response
        const resClone = res.clone();
        // Open Cache
        caches.open(cacheNames).then((cache) => {
          // Add Response To Cache
          cache.put(e.request, resClone);
        });
        return res;
      })
      .catch((err) => {
        return caches.match(e.request).then((res) => res);
      })
  );
});
