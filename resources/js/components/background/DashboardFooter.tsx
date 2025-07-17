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
  <img src="/images/hsac.png" alt="Logo 3" className="h-16 w-auto" />
  <img src="/images/4ph.png" alt="Logo 1" className="h-16 w-auto" />
  <img 
    src="/images/bp.png" 
    alt="Logo 2" 
    className="h-20 w-auto" 
    style={{ filter: 'drop-shadow(0 0 2px white)' }}
  />
</div>


        {/* Title with overlay */}
      <div className="relative flex-grow flex justify-center items-center min-h-[56px] w-full sm:w-auto">
  {/* Gradient background, same size and rounded corners */}
  <div className="absolute inset-0 mx-auto w-full sm:w-auto pointer-events-none rounded-md"
       style={{ 
         background: 'radial-gradient(circle at center, #b58900, #fcd34d, #fff7b3)' 
       }}
  />
  
  {/* Original background overlay for contrast */}
  <div className="absolute inset-0 mx-auto w-full sm:w-auto bg-[#414141]/60 pointer-events-none rounded-md" />
  
  <h1 className="
      relative text-center text-lg xs:text-xl sm:text-3xl md:text-5xl font-extrabold
      text-yellow-300 select-none pointer-events-none px-4 sm:px-6 break-words
      drop-shadow-md
    ">
    CASE MONITORING DASHBOARD
  </h1>
</div>

        {/* Date/time */}
       <div className="flex flex-col items-center text-white flex-shrink-0 whitespace-nowrap">
  <div className="text-3xl xs:text-4xl sm:text-2xl font-semibold">
    {currentTime.format("MMMM D, YYYY")}
  </div>
  <div className="text-xl xs:text-2xl sm:text-lg font-normal mt-1">
    {currentTime.format("h:mm:ss A")}
  </div>
</div>

      </div>
    </footer>
  );
}
