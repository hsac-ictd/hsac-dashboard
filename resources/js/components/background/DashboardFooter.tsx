import { useEffect, useState } from "react";
import dayjs from "dayjs";

export default function DashboardFooter() {
  const [currentTime, setCurrentTime] = useState(dayjs());

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentTime(dayjs());
    }, 1000);
    return () => clearInterval(interval);
  }, []);

  return (
    <footer className="relative z-10 w-full bg-black/20 border-t border-white/20 py-5">
      <div
        className="
          max-w-[3840px] mx-auto flex flex-wrap justify-center sm:justify-between items-center 
          px-4 sm:px-8 gap-4
        "
        style={{ minHeight: 56 }}
      >
        {/* Logos */}
        <div className="hidden sm:flex gap-8 items-center flex-shrink-0">
          <img src="/images/hsac.png" alt="Logo 3" className="h-12 sm:h-16 w-auto" />
          <img src="/images/4ph.png" alt="Logo 1" className="h-12 sm:h-16 w-auto" />
          <img src="/images/bp.png" alt="Logo 2" className="h-12 sm:h-16 w-auto" />
        </div>

        {/* Title with overlay */}
        <div className="relative flex-grow flex justify-center items-center min-h-[56px] w-full sm:w-auto">
          <div className="absolute inset-0 mx-auto w-full sm:w-auto bg-white/40 pointer-events-none rounded-md" />
          <h1 className="
            relative text-center text-base xs:text-lg sm:text-2xl md:text-3xl font-extrabold
            text-white select-none pointer-events-none px-4 sm:px-6 break-words
          ">
            Case Management System - Dashboard Monitoring
          </h1>
        </div>

        {/* Date/time */}
        <div
            className="
              text-2xl xs:text-3xl sm:text-2xl font-semibold text-white flex-shrink-0 whitespace-nowrap
            "
          >
          {currentTime.format("MMMM D, YYYY h:mm:ss A")}
        </div>
      </div>
    </footer>
  );
}
