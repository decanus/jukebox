//
//  PlayerViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit
import CoreMedia

class PlayerViewController: UIViewController {
    
    private let player: Player
    private var slider: UISlider!
    private var durationLabel: UILabel!
    private var elapsedLabel: UILabel!
    private var currentTime: UILabel!
    var artworkView: UIView!
    
    init(player: Player) {
        self.player = player
        super.init(nibName: nil, bundle: nil)
        self.player.setPlayerViewController(self)
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        tabBarItem.title = "Player"
        navigationController?.navigationBarHidden = true
        UIApplication.sharedApplication().statusBarStyle = .LightContent
        view.backgroundColor = UIColor.blackColor()
        
        
        artworkView = UIView(frame: CGRect(x: 0, y: 0, width: view.frame.size.width, height: view.frame.size.width))
        view.addSubview(artworkView)
        
        slider = UISlider(frame: CGRect(x: 0, y: view.frame.size.width - (13 / 2), width: view.frame.size.width, height: 13))
        slider.maximumValueImage = nil
        slider.minimumValue = 0
        slider.maximumValue = 0
        slider.minimumTrackTintColor = UIColor.lightPurpleColor()
        slider.tintColor = UIColor.lightPurpleColor()
        slider.thumbTintColor = UIColor.lightPurpleColor()
        view.addSubview(slider)
        
        elapsedLabel = UILabel(frame: CGRect(x: 16, y: 375 + 16, width: 100, height: 14))
        elapsedLabel.textColor = UIColor.whiteColor()
        elapsedLabel.font.fontWithSize(14)
        elapsedLabel.textAlignment = .Left
        elapsedLabel.text = "--:--"
        view.addSubview(elapsedLabel)
        
        
        durationLabel = UILabel(frame: CGRect(x: view.frame.size.width - (100 + 16), y: 375 + 16, width: 100, height: 14))
        durationLabel.textColor = UIColor.whiteColor()
        durationLabel.font.fontWithSize(14)
        durationLabel.textAlignment = .Right
        durationLabel.text = "--:--"
        view.addSubview(durationLabel)
        
        let playButton = PlayButton(frame: CGRect(x: (view.frame.size.width / 2) - 40, y: 501 - 40, width: 80, height: 80))
        playButton.addTarget(self, action: #selector(PlayerViewController.pause), forControlEvents: .TouchUpInside)
        view.addSubview(playButton)
        
        let previous = UIButton(frame: CGRect(x: (view.frame.size.width / 2) - (40 + 40 + 31), y: 501 - (21 / 2), width: 31, height: 21))
        previous.addTarget(self, action: #selector(PlayerViewController.previous), forControlEvents: .TouchUpInside)
        previous.setImage(UIImage(named: "previous"), forState: .Normal)
        view.addSubview(previous)
        
        let next = UIButton(frame: CGRect(x: (view.frame.size.width / 2) + 40 + 40, y: 501 - (21 / 2), width: 31, height: 21))
        next.addTarget(self, action: #selector(PlayerViewController.next), forControlEvents: .TouchUpInside)
        next.setImage(UIImage(named: "next"), forState: .Normal)
        view.addSubview(next)
    }
    
    func updateSlider(time: CMTime, duration: CMTime) {
        let durationInSeconds = Float(CMTimeGetSeconds(duration))
        
        if slider.maximumValue != durationInSeconds && !durationInSeconds.isNaN {
            slider.maximumValue = durationInSeconds
            durationLabel.text = formatTime(Double(durationInSeconds))
        }

        let elapsed = CMTimeGetSeconds(time)
        elapsedLabel.text = formatTime(Double(elapsed))
        slider.setValue(Float(elapsed), animated: true)
    }
    
    func formatTime(time: Double) -> String{
        let date = NSDate(timeIntervalSince1970: time)
        let formatter = NSDateFormatter()
        formatter.timeZone = NSTimeZone(name: "UTC")
        formatter.dateFormat = "mm:ss"
        return formatter.stringFromDate(date)
    }
    
    override func canBecomeFirstResponder() -> Bool {
        return true
    }
    
    // @move to presenter & interactor
    @objc func pause() {
                
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()

    }
    
    @objc func previous() {
        player.previous()
    }
    
    @objc func next() {
        player.next()
    }
    
    // --
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
