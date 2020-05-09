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
        if (
          posts !== undefined &&
          posts.length == 0 &&
          types !== undefined &&
          types.length == 0
        ) {
          $("#progress-loader").hide();
          $("#scan-start-stop")
            .removeClass("start")
            .removeClass("stop")
            .addClass("disabled")
            .attr("disabled", true)
            .val("Scan completed")
            .off();
          $("#scan-progress").html(
            '<span class="dashicons dashicons-yes"></span>  Scan completed'
          );
          $("#scan-result").append(
            '<p style="color:green;"><span class="dashicons dashicons-yes"></span> Process completed!</p>'
          );
          clearInterval(progressI);
        }
      }

      function checkPost(post_id, recheck = false) {
        // Remove previous post scan data
        if (recheck) {
          $("#total-post" + post_id).remove();
          $("#products-post" + post_id).remove();
          $("#loader-post" + post_id).remove();
        }

        // Add loader to indicate progress
        $("#title-post" + post_id).append(
          '<span id="loader-post' +
            post_id +
            '" class="loader loader10"></span>'
        );

        // Ajax request
        var data = {
          action: "get_post_info",
          id: post_id,
        };
        $.post(ajaxurl, data, function (response) {
          var info = $.parseJSON(response);
          if (!recheck) {
            posts.shift();
          }
          $("#loader-post" + post_id).hide();
          $("#result-post" + post_id).append(
            '<ul id="products-post' + post_id + '"></ul>'
          );
          if (info == null || info.length == 0) {
            $("ul#products-post" + post_id).append(
              "<li>No Amazon links found.</li>"
            );
          } else {
            // Iterate product info and show out of stock
            for (var i = 0; i < info.length; i++) {
              if (info[i].offers === undefined || info[i].offers == "") {
                $("ul#products-post" + post_id).append(
                  '<li><span class="icon has-text-danger"><i class= "fas fa-times" ></i></span > ' +
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
          }
          // Wrap
          $("#result-post" + post_id).append(
            '<p id="total-post' +
              post_id +
              '"><span class="tag is-success is-light">Checked ' +
              info.length +
              " products.</span></p>"
          );
          if (!recheck) {
            $("#actions-post" + post_id).append(
              ' | <a data-post="' +
                post_id +
                '" class="action-recheck start" href="#">Recheck</a>'
            );
          }
        });
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
          return;
        }

        if (current_post == posts[0]) {
          // Keep waiting
          return;
        }

        current_post = posts[0];

        $("#scan-result").append(
          '<div id="result-post' +
            current_post.id +
            '" class="card full-width"><h4 id="title-post' +
            current_post.id +
            '">' +
            current_post.title +
            ' (<span class="actions-post" id="actions-post' +
            current_post.id +
            '"><a href="' +
            current_post.permalink +
            '" target="_blank">View</a> | <a href="post.php?post=' +
            current_post.id +
            '&action=edit">Edit</a></span>)</h4></div>'
        );
        checkPost(current_post.id);
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

      if (posts === undefined) {
        // Kick off the process
        getPosts(types[0]);

        // Post actions
        $("#scan-result").on("click", "a.action-recheck", function (e) {
          e.preventDefault();

          if ($(this).hasClass("start")) {
            // Recheck specific post
            checkPost($(this).data("post"), true);
          }
        });
      } else {
        // Resume the process
        checkPostI = setInterval(checkPosts, speed);
      }
    }

    // Button
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

    $("#check-settings").click(function (e) {
      e.preventDefault();
      window.location = "admin.php?page=pac";
    });
  });
})(jQuery);
