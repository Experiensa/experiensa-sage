export default {
  init() {
    // JavaScript to be fired on all pages
    $('[data-fancybox="group"]').fancybox({
      // Options will go here
      thumbs : {
        autoStart : false,
      },
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
