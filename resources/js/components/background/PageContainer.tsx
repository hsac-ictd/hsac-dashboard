import React, { useEffect, useState } from "react";

interface PageContainerProps {
  children: React.ReactNode;
  className?: string;
  minScale?: number;       // optional minimum scale, default 0.6
  rightMarginPx?: number;  // optional extra right margin in pixels, default 0
}

export function PageContainer({
  children,
  className = "",
  minScale = 0.6,
  rightMarginPx = 0,
}: PageContainerProps) {
  const baseWidth = 1920;   // design width
  const baseHeight = 1080;  // design height

  const [scale, setScale] = useState(1);

  useEffect(() => {
    function updateScale() {
      const screenWidth = window.innerWidth;
      const screenHeight = window.innerHeight;

      const scaleWidth = screenWidth / baseWidth;
      const scaleHeight = screenHeight / baseHeight;

      let newScale = Math.min(scaleWidth, scaleHeight, 1);

      if (newScale < minScale) {
        newScale = minScale;
      }

      setScale(newScale);
    }

    updateScale();
    window.addEventListener("resize", updateScale);
    return () => window.removeEventListener("resize", updateScale);
  }, [minScale]);

  return (
    <div
      className={`w-screen h-screen overflow-hidden ${className}`}
      style={{
        margin: 0,
        padding: 0,
        transformOrigin: "top left",
      }}
    >
      <div
        style={{
          width: baseWidth,
          height: baseHeight,
          transformOrigin: "top left",
          transform: `scale(${scale})`,
          marginLeft: 0,
          marginRight:
            scale < 1
              ? `${rightMarginPx * scale}px`
              : rightMarginPx > 0
              ? `${rightMarginPx}px`
              : undefined,
          paddingLeft: 5,    // smaller fixed left padding
          paddingRight: 5,   // smaller fixed right padding
          boxSizing: "border-box",
        }}
      >
        {children}
      </div>
    </div>
  );
}
