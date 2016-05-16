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
    private var touchUpFlag = false
    private var isAnimating = false
    
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
        adjustsImageWhenHighlighted = false
        
        setImage(UIImage(named: "play"), forState: .Normal)
        imageView?.contentMode = .Center
        bringSubviewToFront((imageView)!)
        exclusiveTouch = true
        addTarget(self, action: #selector(PlayButton.touchDown), forControlEvents: [.TouchDown])
        addTarget(self, action: #selector(PlayButton.touchUp), forControlEvents: [.TouchUpInside, .TouchDragOutside, .TouchCancel, .TouchDragExit])
    }
    
    func touchDown() {
        touchUpFlag = false
        isAnimating = true
        animateFillColorToColor(UIColor.clearColor().CGColor, completion: {
            if self.touchUpFlag {
                self.touchUpAnimation()
            } else {
                self.isAnimating = false
            }
        })
    }
    
    func touchUp() {
        touchUpFlag = true
        
        if !self.isAnimating {
            touchUpAnimation()
        }

    }
    
    func touchUpAnimation() {
        isAnimating = true
        animateFillColorToColor(UIColor.lightPurpleColor().CGColor, completion: {
            self.isAnimating = false
        })
    }
    
    private func animateFillColorToColor(color: CGColor, completion: (() -> Void)?) {
        CATransaction.begin()
        CATransaction.setCompletionBlock(completion)
        
        let animation = CABasicAnimation(keyPath: "fillColor")
        animation.fromValue = self.circle.fillColor
        animation.toValue = color
        animation.duration = 0.25
        animation.repeatCount = 0
        circle.addAnimation(animation, forKey: "fillColor")
        
        CATransaction.commit()
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
}
