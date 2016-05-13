//
//  PlayButton.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class PlayButton: UIButton {
    
    private let circle: CAShapeLayer
    
    override init(frame: CGRect) {
        let circlePath = UIBezierPath(
            arcCenter: CGPoint(x: 0, y: 0),
            radius: CGFloat(frame.size.width / 2),
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        circle = CAShapeLayer()
        circle.path = circlePath.CGPath
        circle.fillColor = UIColor(red: 155 / 255, green: 80 / 255, blue: 186 / 255, alpha: 1).CGColor
        circle.strokeColor = UIColor(red: 155 / 255, green: 80 / 255, blue: 186 / 255, alpha: 1).CGColor
        circle.lineWidth = 3.0
        
        super.init(frame: frame)
        layer.addSublayer(circle)
        
        setImage(UIImage(named: "play"), forState: .Normal)
        imageView?.frame.size = CGSize(width: 20, height: 24)
        imageView?.contentMode = .Center
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
}
