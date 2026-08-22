<?php
/**
 * 級別キャプチャ用 Lightbox（grade.php から include）
 */
?>
<div
  id="grade-lightbox"
  class="grade-lightbox"
  hidden
  role="dialog"
  aria-modal="true"
  aria-labelledby="grade-lightbox-caption"
>
  <div class="grade-lightbox__backdrop" data-grade-lightbox-close tabindex="-1"></div>
  <div class="grade-lightbox__panel">
    <button type="button" class="grade-lightbox__close" data-grade-lightbox-close aria-label="閉じる">
      <span aria-hidden="true">×</span>
    </button>
    <figure class="grade-lightbox__figure">
      <img id="grade-lightbox-img" class="grade-lightbox__img" src="" alt="">
      <figcaption id="grade-lightbox-caption" class="grade-lightbox__caption"></figcaption>
    </figure>
  </div>
</div>
<script>
(function () {
  var root = document.getElementById('grade-lightbox');
  var img = document.getElementById('grade-lightbox-img');
  var caption = document.getElementById('grade-lightbox-caption');
  if (!root || !img || !caption) return;

  var lastFocus = null;

  function openLightbox(src, label, altText) {
    if (!src) return;
    lastFocus = document.activeElement;
    img.src = src;
    img.alt = altText || label || 'アプリ画面の拡大表示';
    caption.textContent = label || '';
    caption.hidden = !label;
    root.hidden = false;
    document.body.classList.add('is-lightbox-locked');
    var closeBtn = root.querySelector('.grade-lightbox__close');
    if (closeBtn) closeBtn.focus();
  }

  function closeLightbox() {
    if (root.hidden) return;
    root.hidden = true;
    document.body.classList.remove('is-lightbox-locked');
    img.removeAttribute('src');
    img.alt = '';
    caption.textContent = '';
    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus();
    }
    lastFocus = null;
  }

  document.addEventListener('click', function (e) {
    var trigger = e.target.closest('[data-grade-lightbox]');
    if (trigger) {
      e.preventDefault();
      openLightbox(
        trigger.getAttribute('data-grade-lightbox') || '',
        trigger.getAttribute('data-grade-lightbox-caption') || '',
        trigger.getAttribute('data-grade-lightbox-alt') || ''
      );
      return;
    }
    if (e.target.closest('[data-grade-lightbox-close]')) {
      closeLightbox();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !root.hidden) {
      e.preventDefault();
      closeLightbox();
    }
  });
})();
</script>
