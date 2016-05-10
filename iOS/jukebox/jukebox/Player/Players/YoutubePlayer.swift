//
//  YoutubePlayer.swift
//  jukebox
//
//  Created by Dean Eigenmann on 10/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import AVFoundation
import youtube_ios_player_helper

// @TODO move delegate, cleanup
class YoutubePlayer: NSObject, PlayerProtocol, YTPlayerViewDelegate {
    
    private let playerView: YTPlayerView
    private let player: Player
    private var loaded = false
    
    
    init(player: Player) {
        self.player = player
        playerView = YTPlayerView(frame: CGRect(x: 0, y: 0, width: 300, height: 200))
        super.init()
        playerView.delegate = self
    }
    
    func pause() {
        playerView.pauseVideo()
    }
    
    func play() {
        playerView.playVideo()
    }
    
    func getPlayerView() -> YTPlayerView {
        return playerView
    }
    
    func setTrack(track: Track) {
        
        if loaded {
            playerView.cueVideoById(track.getID(), startSeconds: 0.0, suggestedQuality: .Auto)
            return
        }
        
        playerView.loadWithVideoId(track.getID(), playerVars: [
            "playsinline" : 1,
            "autoplay" : 1,
            "showinfo" : 0,
            "rel" : 0,
            "modestbranding" : 0,
            "controls" : 0,
            "origin" : "http://www.jukebox.ninja",
            "iv_load_policy" : 3
            ]
        )
        
        loaded = true
    }
    
    func appendPlayerToView(view: UIView, frame: CGRect) {
        playerView.frame = frame
        playerView.backgroundColor = UIColor.clearColor()
        playerView.webView?.userInteractionEnabled = false
        view.addSubview(playerView)
    }
    
    func playerViewDidBecomeReady(playerView: YTPlayerView) {
        playerView.playVideo()
    }
    
    func forwardToLastSecond() {
        playerView.seekToSeconds(Float(playerView.duration() - 1), allowSeekAhead: true)
    }
    
    func playerView(playerView: YTPlayerView, didChangeToState state: YTPlayerState) {
        
        if state == .Ended {
            player.next()
            return
            // @todo, notify player that we have ended
        }
        
        if (UIApplication.sharedApplication().applicationState == .Background || UIApplication.sharedApplication().applicationState == .Inactive) && player.getPlaybackState() == .Playing {
            play()
        }
    }
    
}