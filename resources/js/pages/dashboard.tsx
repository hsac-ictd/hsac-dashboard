import React, { useEffect } from "react";
import { Head, router } from "@inertiajs/react";

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

import DashboardFooter from "@/components/background/DashboardFooter";

import { PageContainer } from "@/components/background/PageContainer";

interface DashboardProps {
  prexcIndicators: Array<{
    id: number;
    description: string;
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
  useEffect(() => {
    //start an interval to reload the data every 30 minutes
    const interval = setInterval(() => {
      router.reload({
        only: [
          "prexcIndicators",
          "appealsAffirmance",
          "courtAffirmanceData",
          "courtAffirmanceMonth",
          "rabCasesData",
          "rabCaseTypeData",
          "appealCaseTypeData",
          "yearlyDisposedCases",
          "yearlyAppealDisposedCases",
          "totalRabCasesFiled",
          "totalRabCasesResolved",
          "totalAppealCasesResolved",
          "totalAppealCasesFiled",
          "totalIndigentLitigants",
          "totalCertificatesSubmitted",
        ],
      });
    }, 1800000); // every 30 mins

    return () => clearInterval(interval);
    // end of interval
  }, []);

  return (
    <div className="dark text-white relative min-h-screen w-full overflow-hidden bg-black">
      <Head title="Dashboard" />

      <img
        src="/images/bg.png"
        alt="Background"
        className="fixed inset-0 w-full h-full object-cover pointer-events-none select-none"
        style={{ opacity: 1, zIndex: 0 }}
      />
      <div className="fixed inset-0 bg-black/80 z-0" />

      {/* Main content above particles */}
      <PageContainer className="relative z-10 space-y-4 bg-transparent text-white" minScale={0.63}>
        <div className="grid grid-cols-1 md:grid-cols-4 gap-y-4 gap-x-2 md:auto-rows-min relative">
          
           <div className="col-span-1 md:col-span-2 lg:col-span-4 -mt-3">
            <DashboardFooter />
          </div>
          {/* First Column */}
          <div>
          <h2 className="text-xl font-semibold mb-1"></h2>

        {/* Stack SectionCards and TResolvedCards vertically with consistent spacing */}
        <div className="grid grid-cols-1">
          <SectionCards totalRabCasesFiled={totalRabCasesFiled} />
          <div className="mt-1 mb-1" />
          <TResolvedCards totalRabCasesResolved={totalRabCasesResolved} />
        </div>

        <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
        <ChartBarHorizontal data={rabCasesData} />
        <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
        <RabCaseTypeChart data={rabCaseTypeData} />
          </div>

          {/* Second Column */}
         <div>
            <h2 className="text-xl font-semibold mb-1"></h2>
            
            <div className="ml-60"> {/* Adjust 'ml-8' to the desired left margin */}
              <TAppealedCasesFiledCard data={totalAppealCasesFiled} />
              <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
              <TAppealedCasesResolvedCard data={totalAppealCasesResolved} />
            </div>

            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <AppealsAffirmanceRatePie data={appealsAffirmance.data} month={appealsAffirmance.month} />
            <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
            <AppealCaseTypeChart data={appealCaseTypeData} />
          </div>


          {/* Third Column */}
          <div className="relative">
            <h2 className="text-xl font-semibold mb-1"></h2>
              {/* <IndigentLitigantsCard data={totalIndigentLitigants} />
              <h2 className="text-xl font-semibold mt-2 mb-1"></h2>
              <CertificateIndigentCard data={totalCertificatesSubmitted} />
              <h2 className="text-xl font-semibold mt-2 mb-1"></h2> */}
                <div className="mt-55">
              <CourtAffirmanceRatePie data={courtAffirmanceData} month={courtAffirmanceMonth} />
          </div>

            {/* Prexc Targets Table */}
            <div
              className="mt-2 flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg rounded-2xl p-2 text-black h-103"
              style={{
                position: "relative",
                width: "calc(200% + 0.5rem)",
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
      </PageContainer>
    </div>
  );
}
