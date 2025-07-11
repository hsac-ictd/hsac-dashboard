import { Head } from "@inertiajs/react";
import { SectionCards } from "@/components/graphs/total-case-filed";
import { TResolvedCards } from "@/components/graphs/total-case-resolved";
import { ChartBarHorizontal } from "@/components/graphs/new-cases-filed";

import { AppealsAffirmanceRatePie } from "@/components/graphs/appeals-affirmance-rate-pie";
import { TAppealedCasesResolvedCard } from "@/components/graphs/total-appealed-resolved";
import { IndigentLitigantsCard } from "@/components/graphs/indigent-litigants-card";
import { RabCaseTypeChart } from "@/components/graphs/table-rab-case-type";

import { TAppealedCasesFiledCard } from "@/components/graphs/total-appealed-filed-card";
import { CertificateIndigentCard } from "@/components/graphs/indigent-certificate-card";
import { CourtAffirmanceRatePie } from "@/components/graphs/court-affirmance-rate-pie";
import { AppealCaseTypeChart } from "@/components/graphs/table-appeal-case-type";

import { NCasesDisposedYearly } from "@/components/graphs/cases-disposed-yearly-graph";
import PrexcTargetsTable from "@/components/graphs/prexc-table";

import Waves from "@/components/background/Particles";

export default function Dashboard() {
  return (
    <div className="relative min-h-screen w-full overflow-hidden bg-black">
      <Head title="Dashboard" />
      {/* Background Particles absolutely fill the container */}
      <div className="absolute inset-0 z-0 pointer-events-none">
        <Waves
          lineColor="#78B9B5"
          backgroundColor="rgba(255, 255, 255, 0.2)"
          waveSpeedX={0.02}
          waveSpeedY={0.01}
          waveAmpX={40}
          waveAmpY={20}
          friction={0.9}
          tension={0.01}
          maxCursorMove={120}
          xGap={12}
          yGap={36}
        />
      </div>
      {/* Main content above particles */}
      <div
        className="relative z-10 p-4 space-y-2 bg-transparent text-white min-h-screen max-w-screen-xl mx-auto"
        style={{ maxWidth: "1920px", minHeight: "1080px" }}
      >
        {/* <h1 className="text-2xl font-bold">Dashboard</h1> */}
        <div className="grid grid-cols-1 md:grid-cols-4 gap-3 md:auto-rows-min relative">
          {/* First Column */}
          <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
            <SectionCards />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <TResolvedCards />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <ChartBarHorizontal />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <RabCaseTypeChart />
          </div>

          {/* Second Column */}
          <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
            <TAppealedCasesResolvedCard />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <IndigentLitigantsCard />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <AppealsAffirmanceRatePie />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <AppealCaseTypeChart />
          </div>

          {/* Third Column */}
          <div className="relative">
            <h2 className="text-xl font-semibold mb-1"></h2>
            <TAppealedCasesFiledCard />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <CertificateIndigentCard />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <CourtAffirmanceRatePie />

            {/* PrexcTargetsTable container expanded to visually cover columns 3 and 4 */}
            <div
              className="mt-2 flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg rounded-2xl p-2 text-black h-80"
              style={{
                position: "relative",
                width: "calc(200% + 1rem)",
                right: "0rem",
                boxSizing: "border-box",
                zIndex: 10,
              }}
            >
              <h2 className="text-xl font-semibold mb-2"></h2>
              <PrexcTargetsTable />
            </div>
          </div>

          {/* Fourth Column */}
          <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
            <NCasesDisposedYearly />
          </div>
        </div>
      </div>
    </div>
  );
}
