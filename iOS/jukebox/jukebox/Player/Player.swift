//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import MediaPlayer

// @todo, next seems buggy
class Player: NSObject, PlayerProtocol {
    
    weak var delegate: PlayerDelegate?
    
    // EXPERIMENTAL, CLEANUP
    // @todo, buffering next track
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
        activateAudioSession()
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
        
        if playerViewController != nil {
//            addPlayer()
        }
        
    }
    
    func hasVideoView() -> Bool {
        return currentTrack is YoutubeTrack
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
        
        if currentTrack is YoutubeTrack {
            youtubePlayer.removePlayerLayer()
        }
    }
    
//    func updateTime(time: CMTime, duration: CMTime) {
//        if playerViewController != nil {
//            playerViewController?.updateSlider(time, duration: duration)
//        }
//    }
//    
//    func addPlayer() {
//        if playerViewController != nil && currentTrack is YoutubeTrack {
//            youtubePlayer.appendPlayerToView((playerViewController?.artworkView)!)
//        }
//    }
    
//    func setPlayerViewController(playerVC: PlayerViewController) {
//        self.playerViewController = playerVC
//        
//        if playbackState == .Playing && currentTrack is YoutubeTrack {
////            addPlayer()
//        }
//    }
//    
    func playerWillEnterForeground() {
        if currentTrack is YoutubeTrack {
            youtubePlayer.enterForeground()
        }
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
    
    private func activateAudioSession() {
        let audioSession = AVAudioSession.sharedInstance()
        do {
            try audioSession.setCategory(AVAudioSessionCategoryPlayback)
            
            do {
                try AVAudioSession.sharedInstance().setActive(true)
            } catch {
                print("Error info: \(error)")
            }
            
        } catch {
            print("Error info: \(error)")
        }
    }
    
}