(function ($) {
  function escapeAttr(value) {
    return String(value || "").replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/</g, "&lt;");
  }

  function preview($root, url, kind) {
    var $box = $root.find("[data-wbc-media-preview]");
    var safe = escapeAttr(url);
    var youtube;
    var vimeo;
    if (!url) {
      $box.empty();
      return;
    }
    if (kind === "image") {
      $box.html('<img src="' + safe + '" alt="">');
      return;
    }
    youtube = String(url).match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]{11})/);
    if (youtube) {
      $box.html('<iframe src="https://www.youtube-nocookie.com/embed/' + youtube[1] + '" title="Video preview" allow="encrypted-media" allowfullscreen></iframe>');
      return;
    }
    vimeo = String(url).match(/vimeo\.com\/(?:video\/)?(\d+)/);
    if (vimeo) {
      $box.html('<iframe src="https://player.vimeo.com/video/' + vimeo[1] + '" title="Video preview" allow="autoplay; fullscreen" allowfullscreen></iframe>');
      return;
    }
    $box.html('<video src="' + safe + '" controls muted playsinline preload="metadata"></video>');
  }

  $(document).on("click", "[data-wbc-media-pick]", function (event) {
    event.preventDefault();
    var $root = $(this).closest("[data-wbc-media]");
    var kind = $(this).data("kind") || "image";
    var $input = $root.find("[data-wbc-media-input]");
    var frame = wp.media({
      title: kind === "video" ? "Select a video" : "Select a photo",
      multiple: false,
      library: { type: kind },
    });
    frame.on("select", function () {
      var file = frame.state().get("selection").first().toJSON();
      $input.val(file.url).trigger("change");
      preview($root, file.url, kind);
    });
    frame.open();
  });

  $(document).on("click", "[data-wbc-media-clear]", function (event) {
    event.preventDefault();
    var $root = $(this).closest("[data-wbc-media]");
    $root.find("[data-wbc-media-input]").val("");
    $root.find("[data-wbc-media-preview]").empty();
  });

  function showTab($tabs, key) {
    if (!$tabs.length || !key) {
      return;
    }
    $tabs.find(".wbc-tabs-btn").removeClass("is-on");
    $tabs.find('[data-tab="' + key + '"]').addClass("is-on");
    $tabs.find(".wbc-tabs-panel").removeClass("is-on");
    $tabs.find('[data-panel="' + key + '"]').addClass("is-on");
  }

  $(document).on("click", "[data-wbc-tabs] [data-tab]", function (event) {
    event.preventDefault();
    var $tabs = $(this).closest("[data-wbc-tabs]");
    var key = String($(this).data("tab") || "");
    showTab($tabs, key);
    try {
      sessionStorage.setItem("wbc-admin-tab", key);
    } catch (error) {}
  });

  $(function () {
    $("[data-wbc-tabs]").each(function () {
      var saved = "";
      try {
        saved = sessionStorage.getItem("wbc-admin-tab") || "";
      } catch (error) {}
      if (saved && $(this).find('[data-tab="' + saved + '"]').length) {
        showTab($(this), saved);
      }
    });
  });

  function galleryThumbs($root, files) {
    var html = files.map(function (file) {
      var src = (file.sizes && file.sizes.medium && file.sizes.medium.url) || file.url;
      return '<img src="' + escapeAttr(src) + '" alt="">';
    }).join("");
    $root.find("[data-wbc-gallery-thumbs]").html(html);
  }

  $(document).on("click", "[data-wbc-gallery]", function (event) {
    event.preventDefault();
    var $root = $(this).closest("[data-wbc-gallery-field]");
    var frame = wp.media({
      title: "Select gallery images",
      multiple: true,
      library: { type: "image" },
    });
    frame.on("select", function () {
      var files = frame.state().get("selection").map(function (item) {
        return item.toJSON();
      });
      $root.find("[data-wbc-gallery-input]").val(files.map(function (file) {
        return file.id;
      }).join(","));
      galleryThumbs($root, files);
    });
    frame.open();
  });

  $(document).on("click", "[data-wbc-gallery-clear]", function (event) {
    event.preventDefault();
    var $root = $(this).closest("[data-wbc-gallery-field]");
    $root.find("[data-wbc-gallery-input]").val("");
    $root.find("[data-wbc-gallery-thumbs]").empty();
  });

  $(document).on("click", "[data-wbc-repeater-add]", function (event) {
    event.preventDefault();
    var $root = $(this).closest("[data-wbc-repeater]");
    var tpl = $root.find("[data-wbc-repeater-template]").get(0);
    var $list = $root.find("[data-wbc-repeater-list]");
    if (!tpl || !tpl.content || !$list.length) {
      return;
    }
    $list.append(tpl.content.cloneNode(true));
  });

  $(document).on("click", "[data-wbc-repeater-remove]", function (event) {
    event.preventDefault();
    var $root = $(this).closest("[data-wbc-repeater]");
    var $row = $(this).closest("[data-wbc-repeater-row]");
    $row.remove();
    if ($root.find("[data-wbc-repeater-list] [data-wbc-repeater-row]").length < 1) {
      $root.find("[data-wbc-repeater-add]").trigger("click");
    }
  });
})(jQuery);
