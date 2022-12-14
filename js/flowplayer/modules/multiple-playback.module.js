flowplayer( function(api,root) {
  if( !api.conf.multiple_playback ) return;

  root = jQuery(root);

  var instance_id = root.data('flowplayer-instance-id');

  flowplayer.audible_instance = -1;

  // if multiple playback is allowed, we discard the splash configuration for this instance
  // that way it won't get unloaded if another player starts playing
  // we need to do this once it actually starts loading, as otherwise Flowplayer would only start buffering the video
  api.one('load', function() {
    // we need to add a bit of wait as otherwise it would require another click to start playing
    setTimeout( function() {
      api.conf.splash = false;
    }, 0 );
  });

  // on iOS only one audible video can play at a time, so we must mute the other players
  api.on('load', function() {
    var i = 0,
      is_muted = root.data('volume') == 0;

    if( !is_muted ) {
      // we go through all the players to mute them all
      jQuery('.flowplayer[data-flowplayer-instance-id]').each( function() {
        var player = jQuery(this).data('flowplayer');

        if( player && player.playing ) {
          player.mute(true,true);
        }
      });

      // mark the current player as the one who is making the noise
      flowplayer.audible_instance = instance_id;
    }

  }).on('mute', function(e,api,muted) {
    // if the player was unmuted, mute the player which was audible previously
    if( !muted && flowplayer.audible_instance != instance_id ) {
      flowplayer(flowplayer.audible_instance).mute(true,true);

      // now our player is audible
      flowplayer.audible_instance = instance_id;
    }

  });
});