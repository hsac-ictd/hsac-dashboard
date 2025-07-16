"use client";

import { Bar, BarChart, CartesianGrid, XAxis, Tooltip, Cell, YAxis, ResponsiveContainer, LabelList } from "recharts";

import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart";

interface AppealDisposedYearlyData {
  year: string;
  disposed: number;
}

interface NAppealCasesDisposedYearlyProps {
  data: AppealDisposedYearlyData[];
}

const colors = [
  "rgba(59, 130, 246, 0.4)",
  "rgba(59, 130, 246, 0.6)",
  "rgba(59, 130, 246, 0.75)",
  "rgba(59, 130, 246, 0.9)",
  "rgba(59, 130, 246, 1)",
];

const chartConfig = {
  disposed: {
    label: "Cases Disposed",
    color: "var(--chart-1)",
  },
} satisfies ChartConfig;

export function NAppealCasesDisposedYearly({ data = [] }: NAppealCasesDisposedYearlyProps) {
  const totalDisposed = data.reduce((sum, entry) => sum + entry.disposed, 0);

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
      <CardHeader>
        <CardTitle className="text-sm md:text-lg">Yearly Appeal Cases Disposed</CardTitle>
        <CardDescription className="text-xs md:text-sm">By Year</CardDescription>
      </CardHeader>

      <CardContent className="h-[140px] md:h-[160px] p-0 overflow-visible">
        <ChartContainer config={chartConfig}>
          <div className="h-full w-full">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                data={data}
                margin={{ top: 15, right: 10, bottom: 120, left: 10 }}
                barCategoryGap={12}
              >
                <CartesianGrid vertical={false} />
                <XAxis
                  dataKey="year"
                  tickLine={false}
                  tickMargin={8}
                  axisLine={true}
                  tick={{ fontSize: 12, fontWeight: "600" }}
                  interval={0}
                />
                <YAxis type="number" domain={[0, "dataMax"]} hide />
                <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
                <Bar dataKey="disposed" radius={[6, 6, 0, 0]}>
                  {data.map((entry, index) => (
                    <Cell key={`cell-${index}`} fill={colors[index % colors.length]} />
                  ))}
                  <LabelList
                    dataKey="disposed"
                    position="top"
                    style={{ fill: "#fafafaff", fontWeight: "bold", fontSize: 12 }}
                  />
                </Bar>
              </BarChart>
            </ResponsiveContainer>
          </div>
        </ChartContainer>
      </CardContent>
    </Card>
  );
}
