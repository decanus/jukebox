//
//  TrackCell.swift
//  jukebox
//
//  Created by Dean Eigenmann on 16/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class TrackCell: UITableViewCell {
    
    init(track: Track) {
        super.init(style: .Subtitle, reuseIdentifier: nil)
        
        selectionStyle = .None
        textLabel?.text = track.getTitle()
        detailTextLabel?.text = "bar"
        
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func setSelected(selected: Bool, animated: Bool) {
        if selected {
            textLabel?.textColor = UIColor.lightPurpleColor()
        } else {
            textLabel?.textColor = UIColor.blackColor()
        }
    }
    
}
