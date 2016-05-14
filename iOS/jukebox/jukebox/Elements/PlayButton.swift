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
    private var whiteCircle: CAShapeLayer?
    private var purpleCircle: CAShapeLayer?
    
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
    }
    
    private func animateWhiteCircle() {
        let circlePath = UIBezierPath(
            arcCenter: CGPoint(x: frame.size.width / 2, y: frame.size.height / 2),
            radius: 0,
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        whiteCircle = CAShapeLayer()
        whiteCircle!.path = circlePath.CGPath
        whiteCircle!.fillColor = UIColor.whiteColor().CGColor
        whiteCircle!.strokeColor = UIColor.whiteColor().CGColor
        whiteCircle!.lineWidth = 3.0
        
        let newPath = UIBezierPath(
            arcCenter: CGPoint(x: frame.size.width / 2, y: frame.size.height / 2),
            radius: CGFloat(frame.size.width / 2),
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        let bounds = NSValue(CGRect: whiteCircle!.bounds)
        
        let animationData: [String: AnyObject] = ["path": newPath.CGPath, "bounds": bounds]
        var animations = [CABasicAnimation]()
        
        for (element, value) in animationData {
            let animation = CABasicAnimation(keyPath: element)
            animation.toValue = value
            animations.append(animation)
        }
        
        let animationGroup = CAAnimationGroup()
        animationGroup.animations = animations
        animationGroup.duration = 0.2
        animationGroup.removedOnCompletion = false
        animationGroup.fillMode = kCAFillModeForwards
        
        layer.insertSublayer(whiteCircle!, atIndex: 1)
        whiteCircle!.addAnimation(animationGroup, forKey: nil)
    }
    
    private func animatePurpleCircle() {
        let circlePath = UIBezierPath(
            arcCenter: CGPoint(x: frame.size.width / 2, y: frame.size.height / 2),
            radius: 0,
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        purpleCircle = CAShapeLayer()
        purpleCircle!.path = circlePath.CGPath
        purpleCircle!.fillColor = UIColor.lightPurpleColor().CGColor
        purpleCircle!.strokeColor = UIColor.lightPurpleColor().CGColor
        purpleCircle!.lineWidth = 3.0
        
        let newPath = UIBezierPath(
            arcCenter: CGPoint(x: frame.size.width / 2, y: frame.size.height / 2),
            radius: CGFloat(frame.size.width / 2),
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        let bounds = NSValue(CGRect: purpleCircle!.bounds)
        
        let animationData: [String: AnyObject] = ["path": newPath.CGPath, "bounds": bounds]
        var animations = [CABasicAnimation]()
        
        for (element, value) in animationData {
            let animation = CABasicAnimation(keyPath: element)
            animation.toValue = value
            animations.append(animation)
        }
        
        let animationGroup = CAAnimationGroup()
        animationGroup.animations = animations
        animationGroup.duration = 0.2
        animationGroup.beginTime = CACurrentMediaTime() + 0.1
        animationGroup.removedOnCompletion = false
        animationGroup.fillMode = kCAFillModeForwards
        animationGroup.delegate = self
        
        layer.insertSublayer(purpleCircle!, atIndex: 2)
        purpleCircle!.addAnimation(animationGroup, forKey: nil)
    }
    
    override func animationDidStop(anim: CAAnimation, finished flag: Bool) {
        whiteCircle?.removeFromSuperlayer()
        purpleCircle?.removeFromSuperlayer()
    }
    
    func animate() {
        
        dispatch_async(dispatch_get_main_queue()) {
            self.animationDidStop(CAAnimationGroup(), finished: false)
            self.animateWhiteCircle()
            self.animatePurpleCircle()
        }
        
        // TODO Refactor
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
}
