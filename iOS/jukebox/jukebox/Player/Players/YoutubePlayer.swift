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
    
    let playerView: YTPlayerView!
    
    init() {
        playerView = YTPlayerView()
    }
    
    func pause() {
        playerView.pauseVideo()
    }
    
    func play() {
        playerView.playVideo()
    }
    
}