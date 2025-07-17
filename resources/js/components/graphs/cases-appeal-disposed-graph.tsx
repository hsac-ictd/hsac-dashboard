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

// Define a light-to-dark palette (blue shades)
const colors = [
  "rgba(59, 130, 246, 0.4)",
  "rgba(59, 130, 246, 0.6)",
  "rgba(59, 130, 246, 0.75)",
  "rgba(59, 130, 246, 0.9)",
  "rgba(59, 130, 246, 1)",
];

const chartConfig = {
  disposed: {
    label: "Disposed",
    color: "var(--chart-1)",
  },
} satisfies ChartConfig;

export function NAppealCasesDisposedYearly({ data = [] }: NAppealCasesDisposedYearlyProps) {
  const totalDisposed = data.reduce((sum, entry) => sum + entry.disposed, 0);

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
      <CardHeader>
        <CardTitle>Yearly Appealed Cases Disposed</CardTitle>
        <CardDescription>By Year</CardDescription>
      </CardHeader>

      <CardContent className="h-[145px] p-0 overflow-visible">
        <ChartContainer config={chartConfig}>
          <div className="h-full w-full">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={data} margin={{ top: 20, right: 5, bottom: 95, left: 5 }} barCategoryGap={10}>
                <CartesianGrid vertical={false} />
                <XAxis dataKey="year" tickLine={false} tickMargin={8} axisLine={true} />
                <YAxis type="number" domain={[0, "dataMax"]} hide />
                <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
                <Bar dataKey="disposed" radius={[4, 4, 0, 0]}>
                  {data.map((entry, index) => (
                    <Cell key={`cell-${index}`} fill={colors[index % colors.length]} />
                  ))}
                  <LabelList 
                    dataKey="disposed" 
                    position="top"
                    style={{ fill: '#fafafaff', fontWeight: 'bold' }}
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