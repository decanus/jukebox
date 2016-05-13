//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import MediaPlayer

class Player: NSObject, PlayerProtocol {
    
    // EXPERIMENTAL, CLEANUP
    var youtubePlayer: YoutubePlayer! = nil
    private var currentTrack: Track?
    private var playbackState: PlaybackState = .Stopped
    private let queue: Queue
    
    // change to presenter
    private weak var playerViewController: PlayerViewController?
    
    override init() {
        queue = Queue()
    }
    
    func addToQueue(track: Track) {
        queue.addTrack(track)
    }
    
    func play() {
        
        if playbackState == .Playing {
            return
        }
        
        if playbackState == .Stopped {
            start()
            return
        }
        
        playbackState = .Playing
        if currentTrack is YoutubeTrack {
            youtubePlayer.play()
        }
        
    }
    
    func pause() {
        if currentTrack is YoutubeTrack {
            youtubePlayer.pause()
        }
        
        playbackState = .Paused
    }
    
    func start() {
        playTrack((queue.getCurrentTrack()))
    }
    
    func next() {
        if playbackState == .Stopped {
            start()
            return
        }

        if queue.hasNext() {
            playTrack(queue.getNextTrack())
            return
        }
        
        stop()
    }
    
    func stop() {
        playbackState = .Stopped
        
        if currentTrack is YoutubeTrack {
            youtubePlayer.pause()
        }
        
        currentTrack = nil
        queue.rewind()
    }
    
    func previous() {
        
        if playbackState == .Stopped {
            start()
            return
        }
        
        if queue.hasPrevious() {
            playTrack(queue.getPreviousTrack())
            return
        }
        
        stop()
        start()
        
    }
    
    func playTrack(track: Track) {
        playbackState = .Playing
        
        if track is YoutubeTrack {
            youtubePlayer.setTrack(track)
            youtubePlayer.play()
        }
        
        currentTrack = track
    }
    
    func hasVideoView() -> Bool {
        return currentTrack is YoutubeTrack
    }
    
    func addVideoToView(view: UIView, frame: CGRect) {
        if currentTrack is YoutubeTrack {
            youtubePlayer.appendPlayerToView(view, frame: frame)
        }
    }
    
    func getNowPlaying() -> Track {
        return currentTrack!
    }
    
    func getPlaybackState() -> PlaybackState {
        return playbackState
    }
    
    func getRepeatMode() -> RepeateMode {
        return .None
    }
    
    func playerWillEnterBackground() {
        if playbackState == .Playing {
            play()
        }
    }
    
    func updateTime(time: Float) {
        if playerViewController != nil {
            playerViewController?.updateSlider(time)
        }
    }
    
    func setPlayerViewController(playerVC: PlayerViewController) {
        self.playerViewController = playerVC
    }
    
    func handleRemoteControl(event: UIEvent) {
        switch event.subtype {
        case .RemoteControlPause:
            pause()
        case .RemoteControlPlay:
            play()
        case .RemoteControlNextTrack:
            next()
        case .RemoteControlPreviousTrack:
            previous()
        default:
            return
        }
    }
    
}