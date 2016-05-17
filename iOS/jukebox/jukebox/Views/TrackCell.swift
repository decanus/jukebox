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
        textLabel?.font = UIFont.boldSystemFontOfSize(14)
        detailTextLabel?.text = "bar"
        detailTextLabel?.textColor = UIColor.grayColor()
        detailTextLabel?.font = UIFont.systemFontOfSize(12)
        
        let imageView = UIImageView(image: UIImage(named: "ellipses"))
        imageView.frame = CGRect(x: 0, y: 0, width: 17, height: 5)
        accessoryView = imageView
        
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
