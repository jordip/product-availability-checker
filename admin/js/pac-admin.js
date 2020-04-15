(function ($) {
  "use strict";

  $(document).ready(function ($) {
    // On scan page
    if ($("#scan-result").length) {
      var current_post;
      var types = ["post", "page"];
      var posts;

      var speed = 1000;
      var a = 0;

      var checkPostI;
      var progressI = setInterval(showProgress, speed);

      function showProgress() {
        // Progress animation
        a++;
        var dot = ".";
        $("#dot-progress").text(dot.repeat((a % 3) + 1));

        // Check if we are done
        if (posts != undefined && posts.length == 0) {
          clearInterval(progressI);
        }
      }

      // Get the post info, including product availability
      function checkPosts() {
        if (posts.length == 0) {
          // No more posts, are there any other post types?
          types.shift();
          if (types.length > 0) {
            clearInterval(checkPostI);
            getPosts(types[0]);
            return;
          }
          // Completely done
          clearInterval(checkPostI);
          $("#scan-result").append(
            '<p style="color:green;"><span class="dashicons dashicons-yes"></span> Process completed!</p>'
          );
          return;
        }

        if (current_post == posts[0]) {
          // Keep waiting
          return;
        }

        current_post = posts[0];
        var data = {
          action: "get_post_info",
          id: current_post.id,
        };
        $("#scan-result").append(
          "<p><h4>" +
            current_post.title +
            ' (<a href="' +
            current_post.permalink +
            '" target="_blank">View</a> | <a href="post.php?post=' +
            current_post.id +
            '&action=edit">Edit</a>)</h4></p>'
        );
        $.post(ajaxurl, data, function (response) {
          var info = $.parseJSON(response);
          posts.shift();
          $("#scan-result").append(
            '<ul id="' + current_post.id + '-products"></ul>'
          );
          if (info == null || info.length == 0) {
            $("ul#" + current_post.id + "-products").append(
              "<li>No Amazon links found.</li>"
            );
          } else {
            // Iterate product info and show out of stock
            for (var i = 0; i < info.length; i++) {
              if (info[i].offers == undefined || info[i].offers == "") {
                $("ul#" + current_post.id + "-products").append(
                  '<li><span style="color:red">[x]</span> ' +
                    info[i].asin +
                    " - " +
                    info[i].title.substr(0, 50) +
                    '... (<a href="' +
                    info[i].url +
                    '" target="_blank">View</a>) ' +
                    info[i].offers +
                    "</li>"
                );
              }
            }
            // Wrap
            $("ul#" + current_post.id + "-products").append(
              "<li>Checked " + info.length + " products.</li>"
            );
          }
        });
      }

      // Get all post ids
      function getPosts(type) {
        var data = {
          action: "get_post_ids",
          content_type: type,
        };
        $.post(ajaxurl, data, function (response) {
          posts = $.parseJSON(response);
          $("#scan-result").append(
            "<p>Found " + posts.length + " published " + type + "s.</p>"
          );
          checkPostI = setInterval(checkPosts, speed);
        });
      }

      // Kick off the process
      getPosts(types[0]);
    }
  });
})(jQuery);
