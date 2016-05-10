//
//  YoutubePlayer.swift
//  jukebox
//
//  Created by Dean Eigenmann on 10/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation
import youtube_ios_player_helper

class YoutubePlayer: PlayerProtocol {
    
    private let playerView: YTPlayerView!
    let tracks = [Track]()
    
    
    init() {
        playerView = YTPlayerView()
        playerView.loadWithVideoId("Ri7-vnrJD3k", playerVars: [
            "playsinline" : 1,
            "showinfo" : 0,
            "rel" : 0,
            "modestbranding" : 1,
            "controls" : 1,
            "origin" : "http://www.jukebox.ninja"
            ]
        )
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
    
}