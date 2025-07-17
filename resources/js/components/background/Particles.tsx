import React from "react";

const Waves = () => {
  return (
    <div
      className="absolute inset-0 z-0 pointer-events-none w-full h-full overflow-hidden"
    >
      <img
        src="/storage/image/justice.png" // or "/bg.png" if in public folder
        alt="Background"
        className="w-full h-full object-cover select-none"
        style={{
          objectPosition: "center",
        }}
      />
    </div>
  );
};

export default Waves;
