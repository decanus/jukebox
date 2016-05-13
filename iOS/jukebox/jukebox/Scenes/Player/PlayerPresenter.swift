//
//  PlayerPresenter.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import CoreMedia

class PlayerPresenter: NSObject, PlayerInteractorOutput, PlayerDelegate {
    
    weak private var output: PlayerPresenterOutput!
    
    init(output: PlayerPresenterOutput) {
        self.output = output
    }
    
    func player(player: Player, shouldUpdateElapsedTime elapsedTime: CMTime) {
        let elapsedTime = CMTimeGetSeconds(elapsedTime)
        output.setPlayerProgressSliderValue(Float(elapsedTime))
        output.updateElapsedTimeLabel(formatTime(Double(elapsedTime)))
    }
    
    private func formatTime(time: Double) -> String {
        let date = NSDate(timeIntervalSince1970: time)
        let formatter = NSDateFormatter()
        formatter.timeZone = NSTimeZone(name: "UTC")
        formatter.dateFormat = "mm:ss"
        return formatter.stringFromDate(date)
    }
}