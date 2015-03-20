
	</div><!-- .site-content -->

<?php wp_footer(); ?>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>

     $(function() {
          //TWITTER FOLLOWER COUNT
          $.ajax({
               url: "https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names=<?php echo get_option('twitter_handle'); ?>",
               dataType : "jsonp",
               crossDomain : true
          }).done(function(data) {
               $(".twitter_count").html(data[0]['followers_count']);
          });
          //INSTAGRAM USER COUNT
          // https://instagram.com/oauth/authorize/?client_id=257e42116b554640a1d842f96c7bec73&redirect_uri=http://silencethegrowl.dev&response_type=token
          $.ajax({
               type: "GET",
               dataType: "jsonp",
               cache: true,
            url: "https://api.instagram.com/v1/users/145527455/?access_token=145527455.257e421.1cd164f2804244d58153d3caff0151ce",
               success: function(data) {
                    var ig_count = data.data.counts.followed_by.toString();
                    ig_count = add_commas(ig_count);
                    $(".instagram_count").html(ig_count);
               }
          });
          function add_commas(number) {
               if (number.length > 3) {
                    var mod = number.length % 3;
                    var output = (mod > 0 ? (number.substring(0,mod)) : '');
                    for (i=0 ; i < Math.floor(number.length / 3); i++) {
                         if ((mod == 0) && (i == 0)) {
                              output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
                         } else {
                              output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
                         }
                    }
                    return (output);
               } else {
                    return number;
               }
          }
     });
</script>

</body>
</html>
