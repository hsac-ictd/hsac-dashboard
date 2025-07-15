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
import { NAppealCasesDisposedYearly } from "@/components/graphs/cases-appeal-disposed-graph";

import PrexcTargetsTable from "@/components/graphs/prexc-table";

import Waves from "@/components/background/Particles";

interface DashboardProps {
  prexcIndicators: Array<{
    id: number;
    indicator: string;
    target: number;
    accomplishment: number;
    percentage_of_accomplishment: number;
    year: number;
  }>;
  appealsAffirmance: {
    data: Array<{
      outcome: string;
      total: number;
    }>;
    month: string | null;
  };
  courtAffirmanceData: Array<{
    outcome: string;
    total: number;
  }>;
  courtAffirmanceMonth: string | null;

  rabCasesData: Array<{
    region: string;
    value: number;
  }>;

  rabCaseTypeData: Array<{
    name: string;
    newCasesFiled: number;
    disposed: number;
  }>;

  appealCaseTypeData: Array<{
    name: string;
    newCasesFiled: number;
    disposed: number;
  }>;

  yearlyDisposedCases: Array<{ 
    year: string; 
    disposed: number;
  }>;

  yearlyAppealDisposedCases: Array<{ 
    year: string; 
    disposed: number;
  }>;

  totalRabCasesFiled: number; 
  totalRabCasesResolved: number;
  totalAppealCasesResolved: number;
  totalAppealCasesFiled: number;
  totalIndigentLitigants: number;
  totalCertificatesSubmitted: number;
}

export default function Dashboard({
  prexcIndicators,
  appealsAffirmance,
  courtAffirmanceData,
  courtAffirmanceMonth,
  rabCasesData,
  rabCaseTypeData,
  appealCaseTypeData,
  yearlyDisposedCases,
  yearlyAppealDisposedCases,
  totalRabCasesFiled,
  totalRabCasesResolved,
  totalAppealCasesResolved,
  totalAppealCasesFiled,
  totalIndigentLitigants,
  totalCertificatesSubmitted,
}: DashboardProps) {

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
        <div className="grid grid-cols-1 md:grid-cols-4 gap-3 md:auto-rows-min relative">
          {/* First Column */}
          <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
             <SectionCards totalRabCasesFiled={totalRabCasesFiled} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <TResolvedCards totalRabCasesResolved={totalRabCasesResolved} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <ChartBarHorizontal data={rabCasesData} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <RabCaseTypeChart data={rabCaseTypeData} />
          </div>

          {/* Second Column */}
          <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
            <TAppealedCasesResolvedCard data={totalAppealCasesResolved} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
           <IndigentLitigantsCard data={totalIndigentLitigants} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <AppealsAffirmanceRatePie
              data={appealsAffirmance.data}
              month={appealsAffirmance.month}
            />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <AppealCaseTypeChart data={appealCaseTypeData} />
          </div>

          {/* Third Column */}
          <div className="relative">
            <h2 className="text-xl font-semibold mb-1"></h2>
            <TAppealedCasesFiledCard data={totalAppealCasesFiled} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <CertificateIndigentCard data={totalCertificatesSubmitted} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <CourtAffirmanceRatePie
              data={courtAffirmanceData}
              month={courtAffirmanceMonth}
            />

            {/* Prexc Targets Table */}
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
              <PrexcTargetsTable data={prexcIndicators} />
            </div>
          </div>

          {/* Fourth Column */}
          <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
            <NCasesDisposedYearly data={yearlyDisposedCases} />
            <h2 className="text-xl font-semibold mb-2"></h2>
            <NAppealCasesDisposedYearly data={yearlyAppealDisposedCases} />
          </div>
        </div>
      </div>
    </div>
  );
}
