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
            arcCenter: CGPoint(x: frame.size.width / 2, y: frame.size.height / 2),
            radius: CGFloat(frame.size.width / 2),
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        circle = CAShapeLayer()
        circle.path = circlePath.CGPath
        circle.fillColor = UIColor.lightPurpleColor().CGColor
        circle.strokeColor = UIColor.lightPurpleColor().CGColor
        circle.lineWidth = 3.0
        
        super.init(frame: frame)
        layer.addSublayer(circle)
        
        setImage(UIImage(named: "play"), forState: .Normal)
        imageView?.contentMode = .Center
        bringSubviewToFront((imageView)!)
        
        addTarget(self, action: #selector(PlayButton.touchDown), forControlEvents: [.TouchDown])
    }
    
    func touchDown() {
        let animation = CABasicAnimation(keyPath: "fillColor")
        animation.fromValue = self.circle.fillColor
        animation.toValue = UIColor.clearColor().CGColor
        animation.duration = 0.13
        animation.repeatCount = 0
        animation.autoreverses = true
        circle.addAnimation(animation, forKey: "strokeColor")
    }
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
}
