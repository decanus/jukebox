//
// Created by Dean Eigenmann on 09/05/16.
// Copyright (c) 2016 jukebox. All rights reserved.
//

import UIKit
import AVFoundation

class TabBarController: UITabBarController, UITabBarControllerDelegate, PlayerDelegate {

    private let player: Player
    private var songTitle: UILabel!
    private var artistName: UILabel!
    // @todo seperate class
    private let playerBar: UIView!
    private var button: PlayButton
    
    init(player: Player) {
        self.player = player
        
        playerBar = UIView()
        button = PlayButton(frame: CGRect(x: 16, y: 19, width: 16, height: 16), type: .Small)
        
        super.init(nibName: nil, bundle: nil)
        delegate = self
        
        let topBorder = CALayer()
        topBorder.frame = CGRect(x: 0, y: 0, width: view.frame.size.width, height: 0.5)
        topBorder.backgroundColor = UIColor.lighterGray().CGColor
        
        playerBar.frame = CGRect(
            x: 0,
            y: tabBar.frame.size.height + tabBar.frame.origin.y,
            width: view.frame.size.width,
            height: tabBar.frame.size.height
        )
        
        playerBar.layer.addSublayer(topBorder)
        
        let recognizer = UITapGestureRecognizer(target: self, action: #selector(self.openPlayerView))
        recognizer.numberOfTapsRequired = 1
        let recognizerView = UIView(frame: CGRect(x: button.frame.origin.x + button.frame.size.width, y: 0, width: playerBar.frame.size.width - (button.frame.origin.x + button.frame.size.width), height: playerBar.frame.size.height))
        recognizerView.addGestureRecognizer(recognizer)
        playerBar.addSubview(recognizerView)
        
        songTitle = UILabel()
        songTitle.textColor = UIColor.blackColor()
        songTitle.font = UIFont.systemFontOfSize(14)
        
        artistName = UILabel()
        artistName.textColor = UIColor.grayColor()
        artistName.font = UIFont.systemFontOfSize(10)
        
        button.addTarget(self, action: #selector(TabBarController.pausePressed), forControlEvents: .TouchUpInside)
        
        playerBar.addSubview(songTitle)
        playerBar.addSubview(artistName)
        playerBar.addSubview(button)
        view.addSubview(playerBar)
    }
    
    func openPlayerView() {
        presentViewController(ViewControllerFactory.createPlayerViewController(), animated: true, completion: nil)
    }
    
    func player(player: Player, shouldUpdateElapsedTime elapsedTime: CMTime) {
        
    }
    
    func player(player: Player, shouldUpdateDuration duration: CMTime) -> Bool {
        return true
    }
    
    func player(player: Player, canPresentVideoLayer videoLayer: AVPlayerLayer) {
        
    }
    
    func player(player: Player, shouldUpdateTrack track: Track) {
        songTitle.text = track.getTitle()
        songTitle.sizeToFit()
        songTitle.center = CGPoint(x: view.frame.width / 2, y: 10 + songTitle.frame.height / 2)
        
        artistName.text = track.getArtist()
        artistName.sizeToFit()
        artistName.center = CGPoint(x: view.frame.width / 2, y: songTitle.frame.size.height + songTitle.frame.origin.y + songTitle.frame.height / 2)
    }
    
    func player(player: Player, shouldUpdatePlaybackState state: PlaybackState) {
        if state != .Stopped {
            animatePlayerBar()
        }
        
        if state == .Playing {
            button.setPlaying()
            return
        }
        
        
        
        button.setPaused()
    }
    
    func animatePlayerBar() {
        UIView.animateWithDuration(0.7, delay: 0, options: .CurveEaseOut, animations: {
            self.playerBar.frame = CGRect(
                origin: CGPoint(x: 0, y: self.tabBar.frame.origin.y - self.playerBar.frame.size.height),
                size: self.playerBar.frame.size
            )
        }, completion: nil)
        
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidAppear(animated: Bool) {
        super.viewDidAppear(animated)
        
        player.delegate = self
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        selectedIndex = 0
    }
    
    func pausePressed() {
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()
    }
}
