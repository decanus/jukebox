//
//  PlayerViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit
import CoreMedia

class PlayerViewController: UIViewController, PlayerPresenterOutput {
    
    var output: PlayerViewControllerOutput!
    
    private var slider: UISlider!
    private var durationLabel: UILabel!
    private var elapsedLabel: UILabel!
    private var currentTime: UILabel!
    private var trackTitle: UILabel!
    private var source: UIButton!
    var artworkView: UIView!
    
/*
    init(player: Player) {
        self.player = player
        super.init(nibName: nil, bundle: nil)
        self.player.setPlayerViewController(self)
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
*/

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

        trackTitle = UILabel(frame: CGRect(x: 0, y: 0, width: 0, height: 0))
        trackTitle.textColor = UIColor.whiteColor()
        trackTitle.font = UIFont.boldSystemFontOfSize(18)
        view.addSubview(trackTitle)

        source = UIButton(type: .System)
        source.setTitleColor(UIColor.whiteColor(), forState: .Normal)
        source.titleLabel?.font = source.titleLabel?.font.fontWithSize(14)
        view.addSubview(source)

        let playButton = PlayButton(frame: CGRect(x: (view.frame.size.width / 2) - 40, y: 501, width: 80, height: 80))
        playButton.addTarget(self, action: #selector(PlayerViewController.pause), forControlEvents: .TouchUpInside)
        view.addSubview(playButton)

        let previous = UIButton(frame: CGRect(x: (view.frame.size.width / 2) - (40 + 40 + 31), y: 501 - (21 / 2) + 40, width: 31, height: 21))
        previous.addTarget(self, action: #selector(PlayerViewController.previous), forControlEvents: .TouchUpInside)
        previous.setImage(UIImage(named: "previous"), forState: .Normal)
        view.addSubview(previous)

        let next = UIButton(frame: CGRect(x: (view.frame.size.width / 2) + 40 + 40, y: 501 - (21 / 2) + 40, width: 31, height: 21))
        next.addTarget(self, action: #selector(PlayerViewController.next), forControlEvents: .TouchUpInside)
        next.setImage(UIImage(named: "next"), forState: .Normal)
        view.addSubview(next)
    }
    
    func setMetadata(title: String, artist: String, platform: Platform) {
        trackTitle.text = title
        trackTitle.sizeToFit()
        trackTitle.center = CGPoint(x: view.frame.width / 2, y: durationLabel.frame.maxY + 19 + trackTitle.frame.height / 2)

        source.setTitle(platform.rawValue.uppercaseString, forState: .Normal)
        source.sizeToFit()
        source.center = CGPoint(x: view.frame.width / 2, y: view.frame.height - source.frame.height - 16 + source.frame.height / 2)
    }
    
/*
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
*/

    func setPlayerProgressSliderValue(value: Float) {
        slider.setValue(value, animated: true)
    }
    
    func setMaximumSliderValue(value: Float) {
        slider.maximumValue = value
    }
    
    func updateElapsedTimeLabel(elapsedTime: String) {
        elapsedLabel.text = elapsedTime
    }
    
    func frameForVideoLayer() -> CGRect {
        return artworkView.frame
    }
    
    func appendPlayerVideoToCoverView(playerVideo: UIView) {
        artworkView.addSubview(playerVideo)
    }
    
    func updateDurationLabel(duration: String) {
        durationLabel.text = duration
    }
    
    @objc func pause() {
        output.pausePressed()
    }
    
    @objc func previous() {
        output.backPressed()
    }
    
    @objc func next() {
        output.nextPressed()
    }
}
