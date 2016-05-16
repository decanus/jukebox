//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import MediaPlayer

// @todo, next seems buggy
// @todo previous crashes
class Player: NSObject, PlayerProtocol {
    
    weak var delegate: PlayerDelegate? {
        didSet {
            if playbackState != .Stopped && delegate != nil {
                delegate?.player(self, shouldUpdateTrack: currentTrack!)
                delegate?.player(self, shouldUpdatePlaybackState: playbackState)
                
                if !(delegate is TabBarController) {
                    youtubePlayer.presentVideoLayer()
                }
                
                youtubePlayer.showElapsed()
                
            } else {
                if !(oldValue is TabBarController) {
                    youtubePlayer.deletePlayerLayer()
                }
            }
        }
    }
    
    // EXPERIMENTAL, CLEANUP
    // @todo, buffering next track
    var youtubePlayer: YoutubePlayer! = nil
    private var currentTrack: Track? {
        didSet {
            if currentTrack != nil {
                delegate?.player(self, shouldUpdateTrack: currentTrack!)
            }
        }
    }
    
    private var playbackState: PlaybackState = .Stopped {
        didSet {
            delegate?.player(self, shouldUpdatePlaybackState: playbackState)
        }
    }
    
    private let queue: Queue
    
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
        activateAudioSession()
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
        let nextTrackCommand = MPRemoteCommandCenter.sharedCommandCenter().nextTrackCommand
        nextTrackCommand.enabled = true
        nextTrackCommand.addTargetWithHandler({_ in return MPRemoteCommandHandlerStatus.Success})
        
        let previousTrackCommand = MPRemoteCommandCenter.sharedCommandCenter().previousTrackCommand
        previousTrackCommand.enabled = true
        previousTrackCommand.addTargetWithHandler({_ in return MPRemoteCommandHandlerStatus.Success})
        
        
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