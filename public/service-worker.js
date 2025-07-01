const CACHE_NAME = 'roomify-v1';
const urlsToCache = [
  '/admin/assets/css/styles.min.css',
  '/admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js',
  '/admin/assets/js/sidebarmenu.js',
  '/admin/assets/js/app.min.js', 
  '/admin/assets/images/logos/icon.png',
  '/home/vendor/bootstrap/css/bootstrap.min.css',
  '/home/vendor/bootstrap-icons/bootstrap-icons.css',
  '/home/vendor/aos/aos.css',
  '/home/vendor/glightbox/css/glightbox.min.css',
  '/home/vendor/swiper/swiper-bundle.min.css',
  '/home/css/main.css',
  '/home/vendor/bootstrap/js/bootstrap.bundle.min.js',
  '/home/vendor/php-email-form/validate.js',
  '/home/vendor/aos/aos.js',
  '/home/vendor/glightbox/js/glightbox.min.js',
  '/home/vendor/purecounter/purecounter_vanilla.js',
  '/home/vendor/imagesloaded/imagesloaded.pkgd.min.js',
  '/home/vendor/isotope-layout/isotope.pkgd.min.js',
  '/home/vendor/swiper/swiper-bundle.min.js',
  '/home/js/main.js',
  '/manifest.json'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        return response || fetch(event.request);
      })
  );
});

self.addEventListener('activate', function(event) {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (!cacheWhitelist.includes(cacheName)) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
