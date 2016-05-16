//
//  PlayButton.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

enum PlayButtonType: Int {
    case Normal
    case Small
}

class PlayButton: UIButton {
    
    private var circle: CAShapeLayer!
    private var touchUpFlag = false
    private var isAnimating = false
    private let type: PlayButtonType
    
    init(frame: CGRect, type: PlayButtonType = .Normal) {
        self.type = type
        super.init(frame: frame)
        
        if type == .Normal {
            setupNormalButton()
        } else {
            setupSmallButton()
        }

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
    
    
    func setPaused() {
        if type == .Normal {
            setImage(UIImage(named: "play"), forState: .Normal)
        } else {
            setImage(UIImage(named: "player-bar-play"), forState: .Normal)
        }
        
    }
    
    func setPlaying() {
        if type == .Normal {
            setImage(UIImage(named: "pause"), forState: .Normal)
        } else {
            setImage(UIImage(named: "player-bar-pause"), forState: .Normal)
        }
        
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
    
    private func setupSmallButton() {
        setImage(UIImage(named: "player-bar-play"), forState: .Normal)
    }
    
    private func setupNormalButton() {
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
        
        layer.addSublayer(circle)
        adjustsImageWhenHighlighted = false
        
        setImage(UIImage(named: "play"), forState: .Normal)
        imageView?.contentMode = .Center
        bringSubviewToFront((imageView)!)
        exclusiveTouch = true
        addTarget(self, action: #selector(PlayButton.touchDown), forControlEvents: [.TouchDown])
        addTarget(self, action: #selector(PlayButton.touchUp), forControlEvents: [.TouchUpInside, .TouchDragOutside, .TouchCancel, .TouchDragExit])
    }
    
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
}
