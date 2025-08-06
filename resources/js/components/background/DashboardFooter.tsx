import { useEffect, useState } from "react";
import dayjs from "dayjs";

export default function DashboardHeader() {
  const [currentTime, setCurrentTime] = useState(dayjs());

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentTime(dayjs());
    }, 1000);
    return () => clearInterval(interval);
  }, []);

  return (
    <header className="relative z-10 w-full bg-black/20 border-b border-white/20 pt-6 pb-0 -mb-4">
      <div
        className="max-w-[3840px] mx-auto flex flex-nowrap justify-between items-center px-4 sm:px-8"
        style={{ minHeight: 32 }}
      >
        {/* Logos */}
        <div className="flex gap-8 items-center flex-shrink-0">
          <img src="/images/hsac.png" alt="HSAC Logo" className="h-16 sm:h-20 w-auto" />
          <img src="/images/iso.png" alt="ISO Logo" className="h-12 sm:h-16 w-auto" />

       

        {/* Title */}
        <div className="relative flex-grow flex justify-center items-center min-h-[40px] max-w-[55%] overflow-hidden">
          <div className="absolute inset-0 mx-auto w-full bg-[#444444] pointer-events-none rounded-md" />
          <h1
            className="
              relative text-center text-lg xs:text-xl sm:text-3xl md:text-[2.450rem] font-extrabold
              text-white select-none pointer-events-none px-4 sm:px-6 truncate drop-shadow-md
            "
          >
            CASE MONITORING DASHBOARD
          </h1>
        </div>

      
          <img src="/images/4ph.png" alt="4PH Logo" className="h-16 sm:h-20 w-auto" />
          <img
            src="/images/bp.png"
            alt="BP Logo"
            className="h-16 sm:h-20 w-auto"
            style={{ filter: "drop-shadow(0 0 2px white)" }}
          />
       
        </div>

        {/* Time */}
        <div className="flex flex-col items-center text-white flex-shrink-0 whitespace-nowrap -mt-3 ml-2">
          <div className="text-xl sm:text-2xl font-semibold">
            As of {currentTime.format("MMMM D, YYYY")}
          </div>
          <div className="text-base font-normal mt-1">
            {currentTime.format("h:mm:ss A")}
          </div>
        </div>
      </div>
    </header>
  );
}
