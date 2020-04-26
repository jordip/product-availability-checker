(function ($) {
  "use strict";

  $(document).ready(function ($) {
    var checkPostI;
    var progressI;
    var posts;

    function scan(action) {
      var current_post;
      var types = ["post", "page"];

      var speed = 1000;
      var a = 0;

      progressI = setInterval(showProgress, speed);

      function showProgress() {
        // Check if we are done
        if (posts != undefined && posts.length == 0) {
          $("#progress-loader").hide();
          $("#scan-progress").html(
            '<span class="dashicons dashicons-yes"></span>  Scan finished'
          );
          clearInterval(progressI);
        }
      }

      // Get the post info, including product availability
      function checkPosts() {
        // The process is on hold
        if ($("#scan-start-stop").hasClass("start")) {
          clearInterval(checkPostI);
          $("#progress-loader").hide();
          $("#scan-progress").html("Scan manually stopped");
          clearInterval(progressI);
          return;
        }

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
          '<div id="result-post' +
            current_post.id +
            '" class="card full-width"><h4 id="title-post' +
            current_post.id +
            '">' +
            current_post.title +
            ' (<a href="' +
            current_post.permalink +
            '" target="_blank">View</a> | <a href="post.php?post=' +
            current_post.id +
            '&action=edit">Edit</a>)</h4></div>'
        );
        // Add loader to indicate progress
        $("#title-post" + current_post.id).append(
          '<span id="loader-post' +
            current_post.id +
            '" class="loader loader10"></span>'
        );
        $.post(ajaxurl, data, function (response) {
          var info = $.parseJSON(response);
          posts.shift();
          $("#loader-post" + current_post.id).hide();
          $("#result-post" + current_post.id).append(
            '<ul id="products-' + current_post.id + '"></ul>'
          );
          if (info == null || info.length == 0) {
            $("ul#products-" + current_post.id).append(
              "<li>No Amazon links found.</li>"
            );
          } else {
            // Iterate product info and show out of stock
            for (var i = 0; i < info.length; i++) {
              if (info[i].offers == undefined || info[i].offers == "") {
                $("ul#products-" + current_post.id).append(
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
            $("#result-post" + current_post.id).append(
              "<p>Checked " + info.length + " products.</p>"
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

      if (posts == undefined) {
        // Kick off the process
        console.log("start");
        getPosts(types[0]);
      } else {
        // Resume the process
        console.log("resume");
        checkPostI = setInterval(checkPosts, speed);
      }
    }

    $("#scan-start-stop").click(function (e) {
      if ($(this).hasClass("start")) {
        // Start / Resume scanning
        $(this).removeClass("start").addClass("stop");
        $(this).val("Stop scanning");
        $("#scan-progress").html("Scanning");
        $("#progress-loader").show();
        $("#scan-result").show();
        scan();
      } else {
        // Stop scanning
        $(this).removeClass("stop").addClass("start");
        $(this).val("Resume scanning");
      }
    });
  });
})(jQuery);
