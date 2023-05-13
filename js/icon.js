if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    // Dark mode is enabled
    var browserMode = 'dark';
  } else {
    // Light mode is enabled
    var browserMode = 'light';
  }

  var icon_dark = document.createElement('link');
  icon_dark.rel = 'icon';
  icon_dark.href = '../image/eksu-white.ico';

  var icon_light = document.createElement('link');
  icon_light.rel = 'icon';
  icon_light.href = '../image/eksu-black.ico';

var iconMetaTag = document.querySelector('#icon_tap');

if (browserMode === 'dark') {
  document.head.appendChild(icon_dark);
} else {
    document.head.appendChild(icon_light);
}
